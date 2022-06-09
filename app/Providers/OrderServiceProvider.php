<?php

namespace App\Providers;

use App\Services\Eloquent\OrderServiceImpl;
use App\Services\OrderService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        OrderService::class => OrderServiceImpl::class
    ];

    public function provides(): array
    {
        return [OrderService::class];
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
