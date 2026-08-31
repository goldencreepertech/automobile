<?php

namespace Automobile;

use Automobile\Console\Commands\InstallCommand;
use Automobile\Console\Commands\SeedCommand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AutomobileServiceProvider extends ServiceProvider
{
    /**
     * Register package services and merge configuration.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/automobile.php', 'automobile');
    }

    /**
     * Bootstrap the package: migrations, routes, publishing, commands.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            $this->registerPublishing();

            $this->commands([
                InstallCommand::class,
                SeedCommand::class,
            ]);
        }
    }

    /**
     * Register the bundled REST API routes when enabled via config.
     */
    protected function registerRoutes(): void
    {
        if (! config('automobile.routes.enabled', true)) {
            return;
        }

        Route::group([
            'prefix' => config('automobile.routes.prefix', 'api/v1'),
            'middleware' => config('automobile.routes.middleware', ['api']),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/automobile.php');
        });
    }

    /**
     * Register the config and migration files as publishable assets.
     */
    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../config/automobile.php' => config_path('automobile.php'),
        ], 'automobile-config');

        // Publish only the package's own (top-level) migration files - never the
        // database/migrations/host/* files, which exist purely for the bundled demo app.
        $migrations = [];

        foreach (glob(__DIR__.'/../database/migrations/*.php') as $path) {
            $migrations[$path] = database_path('migrations/'.basename($path));
        }

        $this->publishes($migrations, 'automobile-migrations');
    }
}
