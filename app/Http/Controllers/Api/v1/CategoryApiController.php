<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController;
use App\Repositories\Admin\CategoryRepository;

class CategoryApiController extends BaseController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

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

    public function getSubCategory($category)
    {
        $urlPrefix = asset('storage' . DIRECTORY_SEPARATOR  . Category::UPLOAD_PATH . DIRECTORY_SEPARATOR );
        $category = $this->categoryRepository->getById($category, true);
        if (empty($category) || empty($category)) {
            return $this->sendFailedResponse('Invalid category selected', self::HTTP_UNPROCESSABLE);
        }

        $subCategories = $this->categoryRepository->getChildCategory($category->id);
        $subCategories->map(function($subcat) use($urlPrefix) {
            $subcat->image = $urlPrefix . $subcat->image;
            return $subcat;
        });

        return $this->sendSuccessResponse('Data listed successfully!', $subCategories);
    }
}
