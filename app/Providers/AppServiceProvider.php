<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Host used in the generated OpenAPI spec's @OA\Server. Defined here so it
        // is available before l5-swagger scans the annotations.
        if (! \defined('L5_SWAGGER_CONST_HOST')) {
            \define('L5_SWAGGER_CONST_HOST', env('L5_SWAGGER_CONST_HOST', config('app.url')));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // The Laravel/Sanctum core tables (users, cache, jobs, personal_access_tokens)
        // live outside database/migrations/ proper so the Automobile package's own
        // service provider can loadMigrationsFrom(database/migrations) without ever
        // touching tables a consuming app already has. This demo app still needs
        // them locally, so they're registered explicitly here.
        $this->loadMigrationsFrom(database_path('migrations/host'));
    }
}
