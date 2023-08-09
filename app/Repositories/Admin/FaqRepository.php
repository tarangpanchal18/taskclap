<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Faq;

class FaqRepository implements MasterInterface
{
    public function getAll()
    {
        return Faq::all();
    }

    public function getRaw($filterData = "")
    {
        $query = Faq::query();
        if ($filterData && $filterData['status']) {
            $query = $query->where('status', $filterData['status']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Faq::findOrFail($id);
    }

    public function delete($id)
    {
        Faq::destroy($id);
    }

    public function create(array $data)
    {
        return Faq::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Faq::whereId($id)->update($newDetails);
    }
}
