<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\AntenaRepositoryInterface;
use App\Repositories\AntenaRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AntenaRepositoryInterface::class, AntenaRepository::class);
    }

    public function boot()
    {
        //
    }
}
