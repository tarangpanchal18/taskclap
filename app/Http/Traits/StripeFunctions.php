<?php
namespace App\Http\Traits;

trait StripeFunctions {

    /**
     * Generates a Price ID for Stripe
     * ref. https://stripe.com/docs/api/prices/create
     */
    public function generatePriceId($price, $productName, $productMetaData, $currency): array|object
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
                    'metadata' => $productMetaData
                ]
            ]);

            return $priceData;
        } catch (\Throwable $th) {
            return $priceData;
        }
    }

    public function generateCheckoutSession($priceId, $qty = 1, $userEmail): array|object
    {
        $checkoutSession = [];
        $stripeSecret = config('app.stripe_secret');
        if (empty($stripeSecret)) {
            return $stripeSecret;
        }

        try {
            \Stripe\Stripe::setApiKey($stripeSecret);
            $checkoutSession = \Stripe\Checkout\Session::create([
                'customer_email' => $userEmail,
                'line_items' => [[
                  'price' => $priceId,
                  'quantity' => $qty,
                ]],
                'mode' => 'payment',
                'success_url' => url('/') . 'success.html',
                'cancel_url' => url('/') . 'cancel.html',
            ]);
            return $checkoutSession;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return $checkoutSession;
        }
    }
}
