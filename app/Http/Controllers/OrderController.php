<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\StripePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class OrderController extends Controller
{
    /**
     * Create a new order and process payment.
     *
     * @param Request $request
     * @param StripePaymentService $stripePaymentService
     *
     * @return JsonResponse
     */
    public function processOrder(Request $request, StripePaymentService $stripePaymentService)
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);

            $amount = $request->input('amount');

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $amount
            ]);

            $paymentStatus = $stripePaymentService->processPayment($amount) ? 'paid' : 'failed';
            $order->update(['payment_status' => $paymentStatus]);

            return response()->json([
                'order' => [
                    'orderId' => $order->id,
                    'totalAmount' => $order->total_amount,
                    'paymentStatus' => $order->payment_status,
                    'user' => $order->user->name
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your order'], 500);
        }
    }
}
