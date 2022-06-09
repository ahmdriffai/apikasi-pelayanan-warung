<?php

namespace App\Providers;

use App\Services\Eloquent\MenuCartServiceImpl;
use App\Services\MenuCartService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MenuCartServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
      MenuCartService::class => MenuCartServiceImpl::class
    ];

    public function provides(): array
    {
        return [MenuCartService::class];
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
