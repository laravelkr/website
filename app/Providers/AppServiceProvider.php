<?php

namespace App\Providers;

use App\Services\ModernPug\Recruits;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use JsonMapper;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(Recruits::class, function ($app) {
            return new Recruits($app[Client::class], $app[JsonMapper::class], config('modernpug.token'));
        });
    }

    public function boot(): void
    {
        //
    }
}
