<?php

namespace App\Repositories\Admin;

use App\Models\Order;
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

    public function delete($id)
    {
        Order::destroy($id);
    }
}
