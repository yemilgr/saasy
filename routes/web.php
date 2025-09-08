<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/billing', function (Request $request) {
    $request->user()->syncOrCreateStripeCustomer();
    return $request->user()->redirectToBillingPortal(route('home'), []);
})
    ->middleware(['auth'])->name('billing');

Route::get('checkout/success', function (Request $request) {
    dd($request->all());
})->name('checkout.success');

Route::get('checkout/cancel', function (Request $request) {
    dd($request->all());
})->name('checkout.cancel');


Route::get('checkout/{price}', function (Request $request, \App\Models\PlanPrice $price) {
    //$request->user()->syncOrCreateStripeCustomer();

    return $request->user()
        ->newSubscription($price->plan->name, $price->stripe_price_id)
        ->allowPromotionCodes()
        //->trialDays(7)
        ->checkout([
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);
})->middleware('auth')->name('checkout');
