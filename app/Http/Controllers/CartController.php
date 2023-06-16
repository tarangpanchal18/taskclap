<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    use GeneralFunctions;

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository
    ) {
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

    function checkout(Request $request): View|RedirectResponse
    {
        $this->setCartCheckpoint($request);

        $total = $totalSaving = 0;
        if (empty($request->category) || empty($request->subcategory)) {
            return redirect(route('homepage'));
        }

        $cartItems = getCartItems();
        $cat = $this->categoryRepository->getById($request->category, true);
        $subCat = $this->categoryRepository->getById($request->subcategory, true);
        if ((! $cat)|| (! $subCat)) {
            return redirect(route('homepage'));
        }
        $cartItemsArr = $this->filterCartItemsBasedOnCat($cartItems, $cat, $subCat);
        $cartItems = $this->productRepository->getAll()->whereIn('id', array_keys($cartItemsArr))->get();
        foreach ($cartItems as $cartItem) {
            $total = ($total + ($cartItem->price * $cartItemsArr[$cartItem->id]));
            $totalSaving = ($totalSaving + ($cartItem->strike_price * $cartItemsArr[$cartItem->id]));
        }

        return view('checkout', [
            'cartArray' => $cartItems,
            'cartItemsArr' => $cartItemsArr,
            'total' => $total,
            'totalSaving' => $totalSaving,
        ]);

    }

    public function addAddress (Request $request): JsonResponse
    {
        $request->validate([
            'house_no' => 'required|min:1|max:25',
            'landmark' => 'required|min:3|max:50',
            'address' => 'required|min:10|max:100',
        ]);

        $user = auth()->user();
        $update = $user->update([
            'house_no' => trim($request->house_no),
            'landmark' => trim($request->landmark),
            'address' => trim($request->address)
        ]);

        if ($update) {
            return response()->json([
                'success' => $update,
            ]);
        }
    }

    public function fetchAddress() {
        $address = auth()->user()->address;
        $house_no = auth()->user()->house_no;
        $landmark = auth()->user()->landmark;

        return response()->json([
            'success' => ($address) ? true : false,
            'house_no' => $house_no,
            'landmark' => $landmark,
            'address' => $address,
        ]);
    }
}
