<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index', [
            'orderData' => Order::paginate(10),
        ]);
    }

    public function orderDetail(Order $order) {
        return view('admin.order.detail', [
            'order' => $order,
        ]);
    }
}
