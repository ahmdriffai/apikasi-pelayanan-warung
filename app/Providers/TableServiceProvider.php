<?php

namespace App\Providers;

use App\Services\Eloquent\TableServiceImpl;
use App\Services\TableService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        TableService::class => TableServiceImpl::class
    ];

    public function provides(): array
    {
        return [TableService::class];
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
