<?php

namespace Maher\Counters;

use Illuminate\Support\ServiceProvider;

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

        include __DIR__.'/routes/web.php';
        $this->app->make('Maher\\Counters\\CountersController');

        $this->mergeConfigFrom(__DIR__ . '/config/counter.php', 'employee');


    }
}
