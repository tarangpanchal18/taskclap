<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\Admin\CategoryRepository;
use Illuminate\Http\Request;
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
        foreach($category->product as $product) {
            if (! empty($product->serviceCategory->name))
                $data[$product->serviceCategory->name] = $product;
        }

        return view('cart', [
            'category' => $category,
            'pageData' => $data,
            'service_type' => array_keys($data),
        ]);
    }
}
