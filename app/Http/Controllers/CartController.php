<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use App\Http\Traits\StripeFunctions;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\PaymentTransactionRepository;
use App\Repositories\Admin\ProductRepository;
use App\Repositories\Admin\PromocodeRepository;
use App\Repositories\Admin\RatingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    use GeneralFunctions, StripeFunctions;

    public function __construct(
        private CategoryRepository $categoryRepository,
        private ProductRepository $productRepository,
        private RatingRepository $ratingRepository,
        private OrderRepository $orderRepository,
        private PromocodeRepository $promocodeRepository,
        private BookingController $bookingController,
        private PaymentTransactionRepository $paymentTransactionRepository
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

    public function fetchService(Request $request)
    {
        $productId = $request->post('productId');
        $product = $this->productRepository->getById($productId);
        $services = $this->productRepository->getRaw([
            'parent_id' => $productId,
            'status' => 'Active',
        ])->get();

        return response()->json([
            'success' => true,
            'product' => $product,
            'services' => $services,
            'cartArray' => getCartItems(),
        ]);
    }

    public function checkout(Request $request): View|RedirectResponse
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
        if (empty($cartItemsArr)) {
            return redirect(route('homepage'));
        }

        $cartItems = $this->productRepository->getAll(false)->whereIn('id', array_keys($cartItemsArr))->get();
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
            'name' => 'required|min:2|max:25',
            'email' => 'nullable|email:rfc,dns|unique:users,email,' . auth()->user()->id .',id',
            'house_no' => 'required|min:1|max:25',
            'landmark' => 'required|min:3|max:50',
            'address' => 'required|min:10|max:100',
        ]);

        $updateData = [
            'name' => trim($request->name),
            'house_no' => trim($request->house_no),
            'landmark' => trim($request->landmark),
            'address' => trim($request->address)
        ];

        if ($request->email) {
            $updateData['email'] = trim($request->email);
        }

        $update = auth()->user()->update($updateData);

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

    public function placeOrder(Request $request) {

        if (empty($request->payment_method) || empty($request->category) || empty($request->subCategory) || empty($request->cartArray)) {
            return redirect(route('orderFailed', ['msg' => 'invalid order placed']));
        }

        $total = $productCount = 0;
        $orderNumber = $this->generateOrderNumber();
        $categoryId = $request->category;
        $subCategoryId = $request->subCategory;
        $promocode = strtoupper($request->promocode);
        $cartItems = json_decode(base64_decode($request->cartArray), true);
        $cartDetail = array_filter(getCartItems());
        if (empty($cartDetail)) {
            return redirect(route('orderFailed', [
                'msg' => 'Cart items are empty'
            ]));
        }

        $orderData = [
            'order_id' => $orderNumber,
            'user_id' => auth()->user()->id,
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'name' => auth()->user()->name,
            'phone' => auth()->user()->phone,
            'email' => auth()->user()->email,
            'address' => auth()->user()->address,
            'house_no' => auth()->user()->house_no,
            'landmark' => auth()->user()->landmark,
            'address_local' => auth()->user()->address,
            'pincode' => '000000',
            'country_id' => auth()->user()->country_id,
            'state_id' => auth()->user()->state_id,
            'city_id' => auth()->user()->city_id,
            'area_id' => auth()->user()->area_id,
            'address_lat' => auth()->user()->address_lat,
            'address_long' => auth()->user()->address_long,
            'product_count' => $productCount,
            'isPromoApplied' => (! empty($promocode)) ? 'Yes' : 'No',
            'promocode' => $promocode,
            'discount' => 0,
            'tax' => 0,
            'subtotal' => $total,
            'total' => $total,
            'is_warranty_order' => 'No',
            'payment_type' => ucfirst(strtolower($request->payment_method)),
            'payment_status' => 'Pending',
            'order_status' => 'Pending',
        ];

        try {
            $orderId = $this->orderRepository->create($orderData);
            foreach ($cartItems as $cart) {
                $quantity = (int)$cartDetail[$cart['id']];
                for ($i = 0; $i < $quantity; $i++) {
                    $cartDetailData = [
                        'order' => $orderNumber,
                        'order_id' => $orderId->id,
                        'product_id' => $cart['id'],
                        'category_id' => $cart['category_id'],
                        'sub_category_id' => $cart['sub_category_id'],
                        'service_category_id' => $cart['service_category_id'],
                        'product_title' => $cart['title'],
                        'product_description' => $cart['description'],
                        'product_strike_price' => $cart['strike_price'],
                        'product_price' => $cart['price'],
                        'product_commission' => $cart['commission'],
                        'warranty' => ($cart['warranty']) ? $cart['warranty'] : 0,
                        'product_approx_duration' => $cart['approx_duration'],
                        'order_status' => "Pending",
                        'order_note' => '',
                    ];

                    $productCount++;
                    $total = $total + $cart['price'];
                    $this->orderRepository->createOrderDetail($cartDetailData);
                }
            }

            $discountPromo = $this->getDiscountValueFromPromo($promocode, $total);
            $this->orderRepository->update($orderId->id, [
                'product_count' => $productCount,
                'subtotal' => $total,
                'discount' => $discountPromo,
                'total' => ($total - $discountPromo),
            ]);

            if ($request->payment_method == "card") {
                $this->bookingController->charge($request, $orderId);
                exit;
            } else {
                $this->clearCartCookies();
                $this->orderRepository->update($orderId->id, [
                    'order_status' => 'Placed'
                ]);

                return redirect(route('orderPlaced', [
                    'success' => 'Order Placed',
                ]));
            }
        } catch (\Throwable $th) {
            return redirect(route('orderFailed', [
                'error' => 'Something went wrong',
                'message' => encryptData($th->getMessage())
            ]));
        }
    }

    public function orderPlaced(Request $request): View
    {
        $session_id = $request->session_id;

        if ($session_id) {
            $getTransaction = $this->paymentTransactionRepository->getRaw()->where([
                'stripe_checkout_session_id' => $session_id,
                'payment_status' => 'Pending',
                'user_id' => auth()->user()->id,
            ])
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->first();

            if ($getTransaction) {
                $this->paymentTransactionRepository->update($getTransaction->id, [
                    'payment_status' => 'Completed'
                ]);
                $this->orderRepository->update($getTransaction->order_id, [
                    'payment_json' => json_encode($getTransaction),
                    'payment_status' => 'Completed',
                ]);
            }
        }
        $this->clearCartCookies();

        return view('order_placed');
    }

    public function orderFailed(): View
    {
        return view('order_failed');
    }

    public function rateOrder(Request $request): bool
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'order' => 'required|integer',
            'rating' => 'required|integer',
            'comment' => 'nullable',
        ]);

        $orderDetail = OrderDetail::findOrFail($validated['id']);
        $rating = [
            'user_id' => auth()->user()->id,
            'order_id' => $validated['order'],
            'order_detail_id' => $validated['id'],
            'product_id' => $orderDetail->product_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ];

        return ($this->ratingRepository->create($rating)) ? true : false;
    }

    public function applyPromocode(Request $request)
    {
        $promocode = $request->promocode;
        $total = (int)$request->total;
        if (! empty($promocode)) {
            $response = [
                'success' => false,
                'message' => "Please Enter Promocode",
            ];
        }

        $getPromo = $this->promocodeRepository->getRaw()->where([
            'promocode' => $promocode,
            'status' => 'Active'
        ])->get();

        if ($getPromo->count() > 0) {
            $discount_type = $getPromo[0]['discount_type'];
            $value = $getPromo[0]['value'];
            $discount = $this->getDiscountValueFromPromo($promocode, $total);

            $response = [
                'success' => true,
                'promo' => $promocode,
                'discount' => $discount,
                'message' => "Promocode ". strtoupper($promocode) ." Applied Successfully !",
            ];
        } else {
            $response = [
                'success' => false,
                'message' => "Entered Promocode is not valid !",
            ];
        }

        echo json_encode($response);
    }

    public function getDiscountValueFromPromo($promocode, $totalAmount): string
    {
        $discount = 0;
        $getPromo = $this->promocodeRepository->getRaw()->where([
            'promocode' => $promocode,
            'status' => 'Active'
        ])->get();

        if ($getPromo->count() > 0) {
            $discount_type = $getPromo[0]['discount_type'];
            $value = $discount = $getPromo[0]['value'];

            if ($discount_type  != "Flat") {
                $discount = (($totalAmount * $value) / 100);
            }
        }

        return $discount;
    }
}
