<?php

namespace App\Providers;

use App\Services\Eloquent\MenuServiceImpl;
use App\Services\MenuService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        MenuService::class => MenuServiceImpl::class
    ];

    public function provides(): array
    {
        return [MenuService::class];
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
