<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Admin\CategoryRepository;

class CategoryApiController extends BaseApiController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }



    public function getSubCategory(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['category' => 'required',]);
        if ($validator->fails()){
            return $this->sendFailedResponse('All Fields are required', self::HTTP_UNPROCESSABLE, $validator->errors() );
        }

        $category = $this->categoryRepository->getById($request->category);
        $urlPrefix = asset('storage' . DIRECTORY_SEPARATOR  . Category::UPLOAD_PATH . DIRECTORY_SEPARATOR );
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
