<?php

return [

    'api' => [
        'max_attempts' => (int) env('API_RATE_LIMIT', 60),
        'decay_seconds' => 60,
    ],

    'api_strict' => [
        'max_attempts' => (int) env('API_RATE_LIMIT_STRICT', 10),
        'decay_seconds' => 60,
    ],

];
