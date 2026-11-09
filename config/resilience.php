<?php

return [

    'fakestore' => [
        'failure_threshold' => (int) env('RESILIENCE_FAILURE_THRESHOLD', 5),
        'open_seconds' => (int) env('RESILIENCE_OPEN_SECONDS', 60),
        'store' => env('RESILIENCE_CACHE_STORE', env('CACHE_STORE', 'redis')),
    ],

];
