<?php

use App\Providers\AppServiceProvider;
use Automobile\AutomobileServiceProvider;

return [
    AppServiceProvider::class,
    // The bundled demo app consumes the package through its own service provider,
    // exactly as a real consuming application would after `composer require`.
    AutomobileServiceProvider::class,
];
