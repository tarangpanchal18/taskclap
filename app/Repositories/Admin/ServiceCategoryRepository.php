<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\ServiceCategory;

class ServiceCategoryRepository implements MasterInterface
{
    public function getAll()
    {
        return ServiceCategory::all();
    }

    public function getRaw($filterData = "")
    {
        $query = ServiceCategory::query();
        if ($filterData && $filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }

        return $query;
    }

    public function getById($id)
    {
        return ServiceCategory::findOrFail($id);
    }

    public function delete($id)
    {
        ServiceCategory::destroy($id);
    }

    public function create(array $data)
    {
        return ServiceCategory::create($data);
    }

    public function update($id, array $newDetails)
    {
        return ServiceCategory::whereId($id)->update($newDetails);
    }
}
