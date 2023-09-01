<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController;

class CategoryApiController extends BaseController
{
    public function index(Request $request): JsonResponse
    {
        $data = Category::whereNull('parent_id');
        if ($cat = $request->id) {
            $data->where('id', $cat);
        }

        return response()->json([
            "success" => true,
            "message" => "Category List",
            "data" => $data->get(),
        ]);
    }

    public function subcategory(Request $request): JsonResponse
    {
        $data = Category::whereNotNull('parent_id');
        if ($cat = $request->category) {
            $data->where('parent_id', $cat);
        }

        return response()->json([
            "success" => true,
            "message" => "SubCategory List",
            "data" => $data->get(),
        ]);
    }
}
