<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\EmployeeRepositoryInterface',
            'App\Repositories\EmployeeRepository'
        );
    }
}
