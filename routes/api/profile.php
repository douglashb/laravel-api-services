<?php

use App\Http\Controllers\Profile\AccountController;
use App\Http\Controllers\Profile\AuthController;
use App\Http\Controllers\Profile\CodeController;
use App\Http\Controllers\Profile\CountryController;

Route::prefix('profile/v1')->group(function () {

    Route::controller(CountryController::class)->group(function () {
        Route::get('/country/{countryIso}/states', 'stateIndex')
            ->name('v1.profile.country_states');

        Route::get('/country/{countryIso}/states/{stateIso}/cities', 'stateIndex')
            ->name('v1.profile.country_cities');
    });

    Route::controller(AccountController::class)->group(function () {
        Route::post('/account', 'store')
            ->name('v1.profile.account');

        Route::post('/password/forgot', 'passwordForgot')
            ->name('v1.profile.password_forgot');

        Route::put('/password/reset', 'passwordReset')
            ->name('v1.profile.password_reset');

        Route::middleware(['verify.jwt'])->group(function () {
            Route::put('/account/activate', 'activateUpdate')
                ->name('v1.profile.account_activate');

            Route::put('/account/password', 'passwordUpdate')
                ->name('v1.profile.account_password');

            Route::put('/account/phone', 'phoneUpdate')
                ->name('v1.profile.account_phone');

            Route::get('/me', 'show')
                ->name('v1.profile.me');
        });
    });

    Route::controller(AuthController::class)->group(function () {
        Route::post('/auth/login', 'login')
            ->name('v1.profile.login');

        Route::middleware(['verify.jwt'])->group(function () {
            Route::post('/auth/logout', 'logout')
                ->name('v1.profile.logout');
        });
    });

    Route::controller(CodeController::class)->group(function () {
        Route::post('/code/active', 'resendActivationCode')
            ->name('v1.code.active');
    });
});
