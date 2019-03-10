<?php

namespace App\Providers;

use App\Services\Documents\GitInitialize;
use App\Services\Documents\InitializeInterface;
use App\Services\Documents\UpdateDateInterface;
use App\Services\Documents\UpdateInterface;
use App\Services\Documents\GitUpdater;
use App\Services\Github\UpdatedDateChecker;
use Illuminate\Support\ServiceProvider;

class DocsServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap services.
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(InitializeInterface::class, function ($app) {
            return $app[GitInitialize::class];
        });

        $this->app->bind(UpdateInterface::class, function ($app) {
            return $app[GitUpdater::class];
        });

        $this->app->bind(UpdateDateInterface::class, function ($app) {
            return $app[UpdatedDateChecker::class];
        });

    }
}
