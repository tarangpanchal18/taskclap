<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
use App\Repositories\Admin\CategoryRepository;

class HomeApiController extends BaseController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

    public function getHomeData(Request $request)
    {
        $fieldToGet =  ['id', 'name', 'description', 'image'];
        $categories = $this->categoryRepository->getRaw([
            'status' => 'Active',
            'parent_id' => null
        ])->select($fieldToGet)->get();
        $categories = $categories->reject(function ($category) {
            return $category->children->count() == 0;
        });
        $reindexedArray = array_values($categories->toArray());

        return $this->sendSuccessResponse('Data listed successfully!', $reindexedArray);
    }
}
