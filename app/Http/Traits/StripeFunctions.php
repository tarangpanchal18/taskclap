<?php
namespace App\Http\Traits;

use App\Models\Order;

trait StripeFunctions {

    /**
     * Generates a Price ID for Stripe
     * ref. https://stripe.com/docs/api/prices/create
     */
    public function generatePriceId($price, $productName, $productMetaData, $currency, $productImage = ''): array|object
    {
        $priceData = [];
        $stripeSecret = config('app.stripe_secret');
        if (empty($stripeSecret)) {
            return $priceData;
        }

        try {
            $stripe = new \Stripe\StripeClient($stripeSecret);
            $priceData = $stripe->prices->create([
                'unit_amount' => $price,
                'currency' => $currency,
                // 'product' => 'prod_OdUGos599Vw4OS',
                'product_data' => [
                    'name' => $productName,
                    'metadata' => $productMetaData,
                    // 'images' => [
                    //     $productImage,
                    // ],
                ]
            ]);

            return $priceData;
        } catch (\Throwable $th) {
            return $priceData;
        }
    }

    public function generateCheckoutSession(array $cartItems, Order $order): array|object
    {
        $checkoutSession = $checkoutArr = [];
        $stripeSecret = config('app.stripe_secret');
        if (empty($stripeSecret)) {
            return $stripeSecret;
        }

        $prevURL = route('checkout', [
            'category' => $cartItems[0]['category']['slug'],
            'subcategory' => $cartItems[0]['sub_category']['slug']
        ]);

        foreach ($cartItems as $items) {
            $productName = $items['title'];
            if (! empty($items['sub_category']['name'])) {
                $productName = $items['sub_category']['name'] . " > " . $items['title'];
            }

            $totalPrice = ($items['price'] * 100);
            $priceStripeId = $this->generatePriceId($totalPrice, $productName, [
                'category_id' => $items['category_id'],
                'sub_category_id' => $items['sub_category_id'],
                'service_category_id' => $items['service_category_id'],
                'strike_price' => $items['strike_price'],
                'warranty' => $items['warranty'],
                'approx_duration' => $items['approx_duration'],
            ], 'inr');

            if (empty($priceStripeId)) {
                $checkoutSession['success'] = false;
                $checkoutSession['errorMsg'] = "Error in creating price id";
                return $checkoutSession;
            }

            $checkoutArr[] = [
                'price' => $priceStripeId->id,
                'quantity' => $items['qty'],
            ];
        }

        try {
            \Stripe\Stripe::setApiKey($stripeSecret);
            $checkoutSessionUrl = \Stripe\Checkout\Session::create([
                'customer_email' => (auth()->user()->email) ? auth()->user()->email : '',
                'line_items' => [
                    $checkoutArr
                ],
                'mode' => 'payment',
                'success_url' => route('orderPlaced') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => $prevURL,
            ]);

            $this->recordTransaction($checkoutSessionUrl, $order->id);

            $checkoutSession['success'] = true;
            $checkoutSession['data'] = $checkoutSessionUrl;
            return $checkoutSession;
        } catch (\Throwable $th) {
            $checkoutSession['success'] = false;
            $checkoutSession['errorMsg'] = $th->getMessage();
            return $checkoutSession;
        }
    }

    public function clearCartCookies() : void
    {
        $past = time() - 3600;
        foreach ($_COOKIE as $key => $value) {
            if ($key == "cartTotal" || $key == "cartDetail") {
                setcookie($key, $value, $past, '/');
            }
        }
    }

    public function recordTransaction($checkoutSession, $orderId, $paymentStatus = 'Pending') : bool
    {
        $paymentTransactionRepository = new \App\Repositories\Admin\PaymentTransactionRepository;
        $transactionData = [
            'user_id' => auth()->user()->id,
            'order_id' => $orderId,
            'product_price' => ($checkoutSession->amount_total / 100),
            'currency' => $checkoutSession->currency,
            'txn_id' => '',
            'stripe_checkout_session_id' => $checkoutSession->id,
            'payment_status' => $paymentStatus,
            'other_data' => json_encode($checkoutSession),
        ];
        $createRecord = $paymentTransactionRepository->create($transactionData);

        if ($createRecord) {
            return true;
        }

        return false;
    }
}
