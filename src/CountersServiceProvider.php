<?php

namespace Maher\Counters;

use Illuminate\Support\ServiceProvider;
use Maher\Counters\Providers\RouteServiceProvider;

class CountersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'Counters');

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'Counters');

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');



    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__ . '/config/counter.php', 'employee');

        $this->app->register(RouteServiceProvider::class);


    }
}
