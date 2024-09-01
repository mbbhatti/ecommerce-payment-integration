<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;

class StripePaymentService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Process the payment using Stripe API.
     *
     * @param float $amount
     * @param string $currency
     * @return bool
     */
    public function processPayment(float $amount, string $currency = 'usd'): bool
    {
        try {
            $charge = Charge::create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'source' => 'tok_visa',
                'description' => 'Order Payment',
            ]);

            return $charge->status === 'succeeded';
        } catch (ApiErrorException $e) {
            return false;
        }
    }
}

