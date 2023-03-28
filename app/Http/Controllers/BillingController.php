<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Cashier\Exceptions\IncompletePayment;

class BillingController extends Controller
{
    public function intent(Request $request) {
        $data['user'] = $request->user();
        $data['intent'] = $request->user()->createSetupIntent();
        $data['item'] = env('STRIPE_SUBCRIPTION_PRICE');
        return $data;
    }

    public function save(Request $request) {
        try {
            $request->user()->newSubscription('default', $request->plan)->create($request->payment_method);
        } catch (IncompletePayment $exception) {
            return [
                'callback_url' => route('cashier.payment', [$exception->payment->id, 'redirect' => 'URL_REPLACE_ME']),       
            ];
        }
        return $request->user()->subscriptions;
    }
}
