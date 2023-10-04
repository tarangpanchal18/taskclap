<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\PaymentTransaction;

class PaymentTransactionRepository implements MasterInterface
{
    public function getAll()
    {
        return PaymentTransaction::all();
    }

    public function getRaw()
    {
        return PaymentTransaction::query();
    }

    public function getById($id)
    {
        return PaymentTransaction::findOrFail($id);
    }

    public function delete($id)
    {
        PaymentTransaction::destroy($id);
    }

    public function create(array $data)
    {
        return PaymentTransaction::create($data);
    }

    public function update($id, array $newDetails)
    {
        return PaymentTransaction::whereId($id)->update($newDetails);
    }
}
