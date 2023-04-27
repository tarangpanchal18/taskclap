<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
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
