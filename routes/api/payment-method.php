<?php


use App\Http\Controllers\PaymentMethod\StripeCardController;

Route::prefix('payment-methods/v1')->middleware(['verify.jwt'])->group(function () {
    Route::controller(StripeCardController::class)->group(function () {
        Route::post('/cards', 'create')
            ->name('v1.cards.create');
    });
});
