<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/health', static function () {
    return response()->json(['code' => 0, 'message' => 'Success']);
});

Route::middleware(['verify.headers', 'verify.api.key'])->group(function () {
    Route::get('/status/test', static function () {
        return response()->json(['code' => 0, 'message' => 'Success']);
    });

    require __DIR__ . '/api/profile.php';
    require __DIR__ . '/api/remittance.php';
    require __DIR__ . '/api/payment-method.php';
});
