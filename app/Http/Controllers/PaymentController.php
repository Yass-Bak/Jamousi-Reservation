<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        // Set your secret Stripe key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Create a PaymentIntent
            $charge = Charge::create([
                'amount' => $request->input('amount'), // Le montant à payer en cents (100 = 1 dollar)
                'currency' => 'eur', // La devise
                'source' => $request->input('token'), // Le token Stripe de la carte de crédit
                'description' => 'Paiement via Stripe', // Description facultative
            ]);

            // Generate a unique payment code (replace this with your logic)
            $paymentCode = uniqid(); // Placeholder, replace with actual logic

            // Le paiement a réussi
            return response()->json(['message' => 'Paiement réussi', 'paymentCode' => $paymentCode]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
