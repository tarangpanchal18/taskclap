<?php
namespace App\Http\Traits;

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
                    'images' => [
                        $productImage,
                    ],
                ]
            ]);

            return $priceData;
        } catch (\Throwable $th) {
            return $priceData;
        }
    }

    public function generateCheckoutSession($cartItems): array|object
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

            $checkoutArr[] = [
                'price' => $priceStripeId->id,
                'quantity' => $items['qty'],
            ];
        }

        try {
            \Stripe\Stripe::setApiKey($stripeSecret);
            $checkoutSession = \Stripe\Checkout\Session::create([
                'customer_email' => (auth()->user()->email) ? auth()->user()->email : '',
                'line_items' => [
                    $checkoutArr
                ],
                'mode' => 'payment',
                'success_url' => route('orderPlaced'),
                'cancel_url' => $prevURL,
            ]);
            return $checkoutSession;
        } catch (\Throwable $th) {
            $checkoutSession['success'] = false;
            $checkoutSession['errorMsg'] = $th->getMessage();
            return $checkoutSession;
        }
    }
}
