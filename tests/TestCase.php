<?php

namespace Tests;

use Automobile\AutomobileServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Load the package into the Testbench skeleton app.
     */
    protected function getPackageProviders($app): array
    {
        return [
            SanctumServiceProvider::class,
            AutomobileServiceProvider::class,
        ];
    }

    /**
     * Configure the throwaway environment: in-memory SQLite + a known static token.
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

        // A consuming app that enables the bundled API has Sanctum's guard configured
        // (it ships in the Laravel skeleton); Testbench's minimal skeleton does not.
        $app['config']->set('auth.guards.sanctum', [
            'driver' => 'sanctum',
            'provider' => 'users',
        ]);

        // Exercise the bundled API regardless of any AUTOMOBILE_ROUTES_ENABLED in the env.
        $app['config']->set('automobile.routes.enabled', true);

        $app['config']->set('static_token.enabled', true);
        $app['config']->set('static_token.token', 'test-token');
    }
}
