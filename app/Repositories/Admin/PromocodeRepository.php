<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Promocode;

class PromocodeRepository implements MasterInterface
{
    public function getAll()
    {
        return Promocode::all();
    }

    public function getRaw()
    {
        return Promocode::query();
    }

    public function getById($id)
    {
        return Promocode::findOrFail($id);
    }

    public function delete($id)
    {
        Promocode::destroy($id);
    }

    public function create(array $data)
    {
        return Promocode::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Promocode::whereId($id)->update($newDetails);
    }
}
