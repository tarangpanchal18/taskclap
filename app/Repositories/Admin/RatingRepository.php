<?php

namespace App\Repositories\Admin;

use App\Interfaces\Admin\MasterInterface;
use App\Models\Rating;

class RatingRepository implements MasterInterface
{
    public function getAll()
    {
        return Rating::all();
    }

    public function getRaw($filterData = "")
    {
        $query = Rating::query();
        if ($filterData && $filterData['user_id']) {
            $query = $query->where('user_id', $filterData['user_id']);
        }

        return $query;
    }

    public function getById($id)
    {
        return Rating::findOrFail($id);
    }

    public function delete($id)
    {
        Rating::destroy($id);
    }

    public function create(array $data)
    {
        return Rating::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Rating::whereId($id)->update($newDetails);
    }
}
