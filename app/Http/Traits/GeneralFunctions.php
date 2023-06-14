<?php
namespace App\Http\Traits;

use App\Models\Product;

trait GeneralFunctions {

    public function filterCartItemsBasedOnCat(array $cartItems, $category, $subCategory): object
    {
        $cartItems = array_filter($cartItems);
        $products = Product::select('id', 'title', 'category_id', 'sub_category_id', 'service_category_id','description', 'image', 'strike_price', 'price', 'warranty', 'approx_duration')->where([
            'category_id' => $category->id,
            'sub_category_id' => $subCategory->id,
            'status' => 'Active',
        ])->get();

        foreach($products as $product) {
            if (! in_array($product->id, array_keys($cartItems))) {
                unset($cartItems[$product->id]);
                return true;
            }
        }
        dd($cartItems);

        $newCartItems = $products->reject(function ($product) use($cartItems) {
            if (! in_array($product->id, array_keys($cartItems))) {
                return true;
            }
        });
        dd($cartItems);

        return $newCartItems;
    }

}
