<?php

use App\Http\Controllers\Remittance\CommonController;
use App\Http\Controllers\Remittance\ProfileManagementController;
use App\Http\Controllers\Remittance\RemittanceController;
use App\Http\Controllers\Remittance\SecurityController;

Route::prefix('remittance/v1')->group(function () {
    /** COMMON UNITELLER */
    Route::controller(CommonController::class)->group(function () {
        Route::get('/licensed-states', 'licensedStates')
            ->name('v1.remittance.licensed_states');

        Route::get('/destination-countries/currencies', 'destCountriesWithCurrencies')
            ->name('v1.remittance.dest_countries_with_currencies');

        Route::get('/reception-methods', 'receptionMethodsName')
            ->name('v1.remittance.reception-methods');

        Route::get('/destination-countries', 'destCountries')
            ->name('v1.remittance.dest_countries');

        Route::get('/countries/{countryIso}/states', 'countryStates')
            ->name('v1.remittance.country_states');

        Route::post('/payers/reception-methods', 'payerWithReceptionMethods')
            ->name('v1.remittance.payers_with_reception_method');

        Route::post('/payers/branches', 'payerBranches')
            ->name('v1.remittance.payers_branches');

        Route::post('/payers/additional-fields', 'payerAdditionalField')
            ->name('v1.remittance.payer_additional_fields');

        Route::get('/states/disclaimer', 'stateDisclaimer')
            ->name('v1.remittance.state_disclaimer');
    });

    Route::controller(RemittanceController::class)->group(function () {
        Route::get('/exchange-rate', 'exchangeRateShow')
            ->name('v1.remittance.exchange_rate');

        Route::post('/quote/external', 'quoteExternalShow')
            ->name('v1.remittance.quote_external');
    });

    Route::middleware(['verify.jwt'])->group(function () {
        /** SECURITY */
        Route::controller(SecurityController::class)->group(function () {
            Route::get('/accounts/status', 'userLogin')
                ->name('v1.remittance.status');

            Route::post('/accounts', 'accountCreate')
                ->name('v1.remittance.account_create');

            Route::put('/accounts/active', 'accountActive')
                ->name('v1.remittance.account_active');
        });

    });

    Route::middleware([
        'verify.jwt',
        'verify.remit.status',
        'verify.remit.session'
    ])->group(function () {
        /** PROFILE MANAGEMENT UNITELLER */
        Route::controller(ProfileManagementController::class)->group(function () {
            /** - PROFILE - */
            Route::get('/profile', 'profileShow')
                ->name('v1.remittance.profile');

            /** - BENEFICIARIES - */
            Route::get('/beneficiaries', 'beneficiaryIndex')
                ->name('v1.remittance.beneficiaries');

            Route::post('/beneficiaries', 'beneficiaryCreate')
                ->name('v1.remittance.beneficiaries_create');

            Route::get('/beneficiaries/{id}', 'beneficiaryShow')
                ->name('v1.remittance.beneficiaries_show');

            Route::delete('/beneficiaries/{id}', 'beneficiaryDelete')
                ->name('v1.remittance.beneficiaries_delete');

            /** - SENDING METHODS - */
            Route::get('/sending-methods', 'sendingMethodIndex')
                ->name('v1.remittance.sending_methods_index');

            Route::get('/sending-methods/{id}', 'sendingMethodShow')
                ->name('v1.remittance.sending_methods_show');

            Route::post('/sending-methods/cards', 'sendingMethodCardCreate')
                ->name('v1.remittance.sending_methods_card_create');

            Route::delete('/sending-methods/{id}', 'SendingMethodDelete')
                ->name('v1.remittance.sending_methods_delete');

            /** - BANK ACCOUNT - */
            Route::get('/sending-methods/bank-accounts/plaid/tokens', 'bankAccountPlaidTokenShow')
                ->name('v1.remittance.plaid_tokens_show');

            Route::post('/sending-methods/bank-accounts/plaid', 'bankAccountPlaidCreate')
                ->name('v1.remittance.plaid_create');
        });

        Route::controller(RemittanceController::class)->group(function () {
            Route::post('/preview', 'sendMoneyPreviewCreate')
                ->name('v1.remittance.preview');

            Route::post('/confirm', 'sendMoneyConfirmCreate')
                ->name('v1.remittance.confirm');

            Route::get('/profile/limit', 'userComplianceLimitShow')
                ->name('v1.remittance.profile_limit');

            Route::get('/transactions', 'transactionsIndex')
                ->name('v1.remittance.transactions');

            Route::get('/transactions/{id}/receipt', 'transactionsReceiptShow')
                ->name('v1.remittance.transaction_receipt');

            Route::delete('/transactions/{id}/receipt', 'transactionDelete')
                ->name('v1.remittance.transaction_delete');

            Route::post('/quote', 'quoteShow')
                ->name('v1.remittance.quote');
        });
    });
});
