<?php

return [
    'enabled' => (bool) env('IS_STATIC_TOKEN', false),
    'token' => env('STATIC_TOKEN'),
];
