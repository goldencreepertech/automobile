<?php

namespace Tests;

use Automobile\AutomobileServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Load the package into the Testbench skeleton app.
     */
    protected function getPackageProviders($app): array
    {
        return [
            AutomobileServiceProvider::class,
        ];
    }

    /**
     * Configure the throwaway environment: in-memory SQLite, bundled routes on.
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        $app['config']->set('automobile.routes.enabled', true);
        $app['config']->set('automobile.routes.prefix', 'api/v1');
        $app['config']->set('automobile.routes.middleware', ['api']);

        // Testbench's minimal skeleton has no "api" rate limiter.
        RateLimiter::for('api', fn () => Limit::perMinute(60));
    }
}
