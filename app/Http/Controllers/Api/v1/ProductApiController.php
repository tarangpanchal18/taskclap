<?php

namespace App\Http\Controllers\Api\v1;

use Validator;
use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends BaseApiController
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

    public function getProducts(Request $request) : JsonResponse
    {
        $serviceType = $productData = $tempArr = [];
        $validator = Validator::make($request->all(), ['subcategory' => 'required',]);
        if ($validator->fails()){
            return $this->sendFailedResponse('All Fields are required', self::HTTP_UNPROCESSABLE, $validator->errors() );
        }

        //Banners Data
        $bannerData = [
            'https://dummyimage.com/600x300/000/fff?text=Banner%201',
            'https://dummyimage.com/600x300/000/fff?text=Banner%202',
            'https://dummyimage.com/600x300/000/fff?text=Banner%203',
        ];
        //$data['banners'] = $bannerData;

        //Subcategory Data
        if(! $subcategory = $this->categoryRepository->getById($request->subcategory)) {
            return $this->sendFailedResponse("Something went Wrong !");
        }

        $productList = $subcategory['product'];
        unset($subcategory['product']);
        foreach($productList as $product) {

            if (! in_array($product->serviceCategory->name, $tempArr)) {
                $productData[] = [
                    'service_type' => $product->serviceCategory->name,
                    'service_image' => $product->serviceCategory->id,
                    'products' => [$product]
                ];
                array_push($tempArr, $product->serviceCategory->name);
            } else {
                $key = array_search('Repair', array_column($productData, 'service_type'));
                dd($key);
                exit;
            }


        }
        // $data['subCategory'] = $subcategory;
        $data['productData'] = $productData;

        return $this->sendSuccessResponse('Data listed successfully!', $data);
    }
}
