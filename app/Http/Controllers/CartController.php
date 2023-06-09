<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private CategoryRepository $categoryRepository) {
        //
    }

    public function index($subcategory): View
    {
        $data = [];
        $category = $this->categoryRepository->getById($subcategory, true);
        if(! $category) abort(500, "Something went Wrong !");

        foreach($category->product as $product) {
            if (! empty($product->serviceCategory->name)) {
                $data[$product->serviceCategory->name][] = $product;
            }
        }

        return view('cart', [
            'category' => $category,
            'pageData' => $data,
            'service_type' => array_keys($data),
            'cartArray' => getCartItems(),
        ]);
    }
}
