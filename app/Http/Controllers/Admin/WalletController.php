<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Http\Request;
use Bavix\Wallet\Models\Transaction;

class WalletController extends Controller
{

    public function __construct(private UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $walletData = [];
        if ($request->user_id) {
            $walletData = Transaction::where('payable_id', trim($request->user_id))->paginate(100);
        }

        return view('admin.report.wallet', [
            'walletData' => $walletData,
            'userData' => $this->userRepository->getAll()->where('status', 'Active')
        ]);
    }

    public function transaction(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'user_id' => 'required|int',
            'amount' => 'required|int|min:1|max:5000',
        ]);

        switch($request->type) {
            case 'deposit':
                $user = User::findOrFail($request->user_id);
                $user->deposit($request->amount);
                break;

            case 'withdraw':
                $user = User::findOrFail($request->user_id);
                $user->withdraw($request->amount);
                break;

            default:
                die("Invalid Type");
                break;
        }

        return redirect()->back()->with('success', 'Wallet Transaction Completed Successfully !');
    }

}
