<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bundled REST API routes
    |--------------------------------------------------------------------------
    |
    | The package ships an optional REST API (manufacturers, models, variants,
    | vehicles, parts). Set "enabled" to false if the consuming application
    | prefers to expose the models through its own controllers/routes.
    |
    */

    'routes' => [
        'enabled' => (bool) env('AUTOMOBILE_ROUTES_ENABLED', true),

        // URI prefix applied to every bundled route, e.g. "api/v1/manufacturers".
        'prefix' => env('AUTOMOBILE_ROUTES_PREFIX', 'api/v1'),

        // Middleware stack applied to the bundled route group.
        'middleware' => ['api', 'auth.static'],
    ],

];
