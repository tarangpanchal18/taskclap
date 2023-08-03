<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $orderData->map(function ($order) {
            $order->orderDetail->map(function ($orderDetail) use ($order) {
                if ($order->order_status == "Completed") {
                    $desired_object = $order->ratings->first(function ($item) use($orderDetail) {
                        return $item->product_id == $orderDetail->product_id;
                    });

                    if($desired_object) {
                        $orderDetail->isRate = true;
                        $orderDetail->rating = $desired_object->rating;
                    } else {
                        $orderDetail->isRate = false;
                        $orderDetail->rating = 0;
                    }
                }
            });
        });

        return view('my_bookings', [
            'pageData' => $orderData,
        ]);
    }

    public function detail($orderId): View
    {
        $orderData = $this->orderRepository->getById($orderId);
        return view('my_bookings_detail', [
            'pageData' => $orderData,
        ]);
    }

    public function downloadInvoice()
    {
        return view('pdf.invoice.booking');
        $pdf = Pdf::loadView('pdf.invoice.booking', [
            'name' => 'invoice',
        ]);
        return $pdf->download('invoice.pdf');
    }
}
