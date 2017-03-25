<?php

namespace App\ServiceProviders\Resources;

use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\RepositoryInterface',
            'App\Repositories\UserRepository'
        );
    }
}