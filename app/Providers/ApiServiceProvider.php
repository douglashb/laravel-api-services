<?php

namespace App\Providers;

use App\Services\Country\CountryService;
use App\Services\IpApi\IpApiService;
use App\Services\QuickEmailVerification\QuickEmailVerificationService;
use App\Services\Supplier\SupplierService;
use App\Services\Uniteller\UnitellerService;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SupplierService::class, static fn () => new SupplierService(config('internal.provider.url')));

        $this->app->singleton(QuickEmailVerificationService::class, function ($app) {
            $merchant = cache(session('merchant'));
            $service = $merchant['services']['email-verify'];

            return new QuickEmailVerificationService($service['service_url'], $service['configs']['public_key']);
        });

        $this->app->singleton(IpApiService::class, function ($app) {
            $merchant = cache(session('merchant'));
            $service = $merchant['services']['ip-api'];

            return new IpApiService($service['service_url']);
        });

        $this->app->singleton(UnitellerService::class, function ($app) {
            $merchant = cache(session('merchant'));
            $service = $merchant['services']['uniteller'];
            session(['remit_partner_code' => $service['configs']['username']]);

            $headers = json_decode($service['configs']['headers'], true);
            $headers['PLATFORM'] = session('user_remote_platform');

            return new UnitellerService($service['service_url'], $headers);
        });

        $this->app->singleton(CountryService::class, function ($app) {
            $merchant = cache(session('merchant'));
            $service = $merchant['services']['countrystatecity'];
            $headers = json_decode($service['configs']['headers'], true);

            return new CountryService($service['service_url'], $headers);
        });

        $this->app->singleton(StripeClient::class, function ($app) {
            $merchant = cache(session('merchant'));
            $service = $merchant['services']['stripe'];

            return new StripeClient($service['configs']['secret_key']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
