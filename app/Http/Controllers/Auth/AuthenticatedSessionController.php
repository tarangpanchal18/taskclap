<?php

namespace App\Http\Controllers\Auth;

use App\Events\LogUserEvent;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralFunctions;
use App\Models\UserAuthenticationLog;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    use GeneralFunctions;

    public const MAX_LOGIN_ATTEMPT = 10;

    /**
     * In Minutes
     */
    public const LOGIN_ATTEMPT_TIME = 30;

    public function create(): View
    {
        return view('auth.login');
    }

    public function create_v1(): View
    {
        return view('auth.login_v1');
    }

    public function validateNumber(Request $request)
    {
        $response['success'] = true;
        $response['msg'] = "Number Validate success !";
        $requestData = $request->all();
        if (empty($requestData['g-recaptcha-response'])) {
            $response['success'] = false;
            $response['msg'] = "Please fill reCAPTCHA";
            $response['extras'] = json_encode($requestData);
            return json_encode($response);
        }

        $phone = trim($request->phone);
        $phone = str_replace('+91', '', $phone);
        $number = preg_replace('/[^0-9]/', '', $phone);
        if (! preg_match('/^(?:\+91|0)?[6-9]\d{9}$/', $number)) {
            $response['success'] = false;
            $response['msg'] = "Please Enter Valid Mobile number";
            return json_encode($response);
        }

        $date = new DateTime();
        $date->modify('-'. self::LOGIN_ATTEMPT_TIME .' minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $getAttempts = UserAuthenticationLog::where([
            'ip_address' => get_client_ip(),
            'username' => $number,
            'login_successful' => 'No',
        ]);
        $getAttempts->where('created_at','>=',$formatted_date)->get();
        if ($getAttempts->count() > self::MAX_LOGIN_ATTEMPT) {
            $response['success'] = false;
            $response['msg'] = "You've Reached Maximum Login Attempt of ". self::MAX_LOGIN_ATTEMPT ." attempts.<br>Please try again after ". self::LOGIN_ATTEMPT_TIME ." minutes.";
            return json_encode($response);
        }

        LogUserEvent::dispatch([
            'user' => $phone,
            'isLoggedIn' => false,
        ]);

        return json_encode($response);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function storeWithOtp(Request $request): string
    {
        $this->validate($request, [
            'phone' => [
                'required','int','digits:10',
            ],
        ]);

        $phone =  trim(str_replace('+91', '', $request->get('phone')));
        $user = User::where('phone', $phone)->first();
        if (! $user) {
            $user = User::create([
                'name' => "Verified User",
                'email' => "",
                'phone' => $request->phone,
                'password' => Hash::make($this->generateStrongPassword()),
                'country_id' => 1,
                'state_id' => 1,
                'city_id' => 1,
                'area_id' => 1,
                'address' => '',
            ]);
        }

        LogUserEvent::dispatch([
            'user' => $phone,
            'isLoggedIn' => true,
        ]);

        Auth::login($user);

        $returnArr['success'] = true;
        $returnArr['loginLink'] = route('homepage');
        if (Session::get('cartProcced')) {
            $returnArr['loginLink'] = route('homepage') . Session::get('cartLink');
        }

        return json_encode($returnArr);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
