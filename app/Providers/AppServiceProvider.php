<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerRepositories()
    {
        $this->app->bind(
            \App\Contracts\Repositories\CustomerRepositoryInterface::class,
            \App\Repositories\CustomerRepository::class
        );
    }

    private function registerServices()
    {
        $this->app->bind(
            \App\Contracts\Services\CustomerServiceInterface::class,
            \App\Services\CustomerService::class
        );
    }
}
