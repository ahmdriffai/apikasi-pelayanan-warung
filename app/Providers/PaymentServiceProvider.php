<?php

namespace App\Providers;

use App\Services\Eloquent\PaymentServiceImpl;
use App\Services\PaymentService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        PaymentService::class => PaymentServiceImpl::class
    ];

    public function provides(): array
    {
        return [PaymentService::class];
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
