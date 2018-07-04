<?php

namespace Maher\Counters;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Maher\Counters\Facades\Counters;
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


        //To load migration files directly from the package
//        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');


        $this->app->booted(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Counters', Counters::class);

        });

        $this->publishes([
            __DIR__ . '/../config/counter.php' => config_path('counter.php'),
        ], 'config');



        $this->publishes([
            __DIR__.'/../database/migrations/0000_00_00_000000_create_counters_tables.php' => $this->app->databasePath()."/migrations/0000_00_00_000000_create_counters_tables.php",
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
