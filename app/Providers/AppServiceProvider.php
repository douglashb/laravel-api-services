<?php

namespace App\Providers;

use App\Libraries\ResponseHandler;
use App\Services\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ResponseHandler::class, fn () => new ResponseHandler());

        $this->app->singleton(Client::class, fn () => new Client());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(! $this->app->isProduction());
    }
}
