<?php

namespace App\Providers;

use App\Interfaces\Profile\CodeRepository;
use App\Interfaces\Profile\SessionRepository;
use App\Interfaces\Profile\UserLocationRepository;
use App\Interfaces\Profile\UserRepository;
use App\Interfaces\Remittance\BeneficiaryRemitRepository;
use App\Interfaces\Remittance\ProfileRemitRepository;
use App\Interfaces\Remittance\SessionRemitRepository;
use App\Interfaces\Remittance\TransactionRemitRepository;
use App\Repositories\Profile\CodeEloquentRepository;
use App\Repositories\Profile\SessionEloquentRepository;
use App\Repositories\Profile\UserEloquentRepository;
use App\Repositories\Profile\UserLocationEloquentRepository;
use App\Repositories\Remittance\BeneficiaryRemitEloquentRepository;
use App\Repositories\Remittance\ProfileRemitEloquentRepository;
use App\Repositories\Remittance\SessionRemitEloquentRepository;
use App\Repositories\Remittance\TransactionRemitEloquentRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserEloquentRepository::class);
        $this->app->bind(CodeRepository::class, CodeEloquentRepository::class);
        $this->app->bind(SessionRepository::class, SessionEloquentRepository::class);
        $this->app->bind(UserLocationRepository::class, UserLocationEloquentRepository::class);
        $this->app->bind(ProfileRemitRepository::class, ProfileRemitEloquentRepository::class);
        $this->app->bind(SessionRemitRepository::class, SessionRemitEloquentRepository::class);
        $this->app->bind(BeneficiaryRemitRepository::class, BeneficiaryRemitEloquentRepository::class);
        $this->app->bind(TransactionRemitRepository::class, TransactionRemitEloquentRepository::class);

        $this->app->bind(TransactionRemitRepository::class, TransactionRemitEloquentRepository::class);
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
