<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProviderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private ProviderRepository $providerRepository,
        private OrderRepository $orderRepository,
    )
    {
        //
    }

    public function index()
    {
        return view('admin.order.index', [
            'orderData' => Order::paginate(10),
        ]);
    }

    public function orderDetail(Order $order) {
        $providerList = $this->providerRepository->getRaw()->select(['id','name'])->where('category_id', 'like', '%'.$order->sub_category_id.'%')->where('status', 'Active')->get();

        return view('admin.order.detail', [
            'order' => $order,
            'orderStatus' => collect(Order::ORDER_STATUS)->reject(function (string $name) use($order) {
                return $order->order_status === $name;
            }),
            'paymentStatus' => collect(Order::PAYMENT_STATUS)->reject(function (string $name) use($order) {
                return $order->payment_status === $name;
            }),
            'providerList' => $providerList,
        ]);
    }

    public function updateOrderDetail(Request $request, Order $order)
    {
        if ($request->type == "assign_provider") {
            $msg = $this->assignProvider($request, $order);
        }

        return redirect(route('admin.orders.detail', $order))->with('success', $msg);
    }

    public function assignProvider(Request $request, Order $order)
    {
        $request->validate(['provider_id' => 'required|int']);
        $this->orderRepository->update($order->id, [
            'provider_id' => $request->provider_id
        ]);

        return "Provider assigned successfully !";
    }
}
