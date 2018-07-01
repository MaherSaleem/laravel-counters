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

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


        $this->publishes([
            __DIR__ . '/../config/counter.php' => config_path('counter.php'),
        ], 'config');



        $this->publishes([
            __DIR__.'/../database/migrations/0000_00_00_000000_create_counters_table.php' => $this->app->databasePath()."/migrations/0000_00_00_000000_create_counters_table.php",
            __DIR__.'/../database/migrations/0000_00_00_000001_create_counterables_table.php' => $this->app->databasePath()."/migrations/0000_00_00_000001_create_counterables_table_create_counterable_table.php",
        ], 'migrations');


        if ($this->app->runningInConsole()) {
            $this->commands([\Maher\Counters\Commands\MakeCounter::class]);
        }


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {



        $this->mergeConfigFrom(__DIR__ . '/../config/counter.php', 'counter');

        $this->app->register(RouteServiceProvider::class);


    }
}
