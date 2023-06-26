<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    use GeneralFunctions;

    public function __construct(
        private OrderRepository $orderRepository,
    ) {
        //
    }

    public function index() : View|RedirectResponse
    {
        $loggedInUser = auth()->user();
        if (! $loggedInUser) {
            return redirect(route('login'));
        }
        $orderData = $this->orderRepository->get($loggedInUser->id);

        return view('my_bookings', [
            'pageData' => $orderData,
        ]);
    }
}
