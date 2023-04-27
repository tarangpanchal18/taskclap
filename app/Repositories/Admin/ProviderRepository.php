<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Provider;

class ProviderRepository implements MasterInterface
{
    public function getAll()
    {
        return Provider::all();
    }

    public function getRaw($filterData = "")
    {
        $query = Provider::query();
        if ($filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }
        if ($filterData['name']) {
            $query = $query->where('name', 'like', '%'.$filterData['name'] .'%');
        }

        return $query;
    }

    public function getById($id)
    {
        return Provider::findOrFail($id);
    }

    public function delete($id)
    {
        Provider::destroy($id);
    }

    public function create(array $data)
    {
        return Provider::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Provider::whereId($id)->update($newDetails);
    }
}
