<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stateless deployment requirements
    |--------------------------------------------------------------------------
    |
    | When running multiple app instances (Docker scale, ECS, EKS), every
    | instance must share these backends — no local file sessions or caches.
    |
    */

    'required' => [
        'SESSION_DRIVER' => 'redis',
        'CACHE_STORE' => 'redis',
        'QUEUE_CONNECTION' => 'redis',
    ],

    'shared_app_key' => env('APP_KEY') !== null && env('APP_KEY') !== '',

];
