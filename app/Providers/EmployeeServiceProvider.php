<?php

namespace App\Providers;

use App\Services\Eloquent\EmployeeServiceImpl;
use App\Services\EmployeeService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        EmployeeService::class => EmployeeServiceImpl::class
    ];

    public function provides(): array
    {
        return [EmployeeService::class];
    }

    public function register()
    {
        //
    }
    public function boot()
    {
        //
    }
}
