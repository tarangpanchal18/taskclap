<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getById($id)
    {
        return Order::findOrFail($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Order::whereId($id)->update($newDetails);
    }

    public function updateOrderDetail($id, array $newDetails)
    {
        return OrderDetail::where('order_id', $id)->update($newDetails);
    }

    public function delete($id)
    {
        Order::destroy($id);
    }
}
