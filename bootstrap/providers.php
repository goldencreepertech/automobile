<?php

return [
    App\Providers\AppServiceProvider::class,
    // The bundled demo app consumes the package through its own service provider,
    // exactly as a real consuming application would after `composer require`.
    Automobile\AutomobileServiceProvider::class,
];
