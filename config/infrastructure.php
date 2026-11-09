<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message bus (Adapter pattern)
    |--------------------------------------------------------------------------
    |
    | laravel_queue | redis_log | kafka | rabbitmq
    |
    */
    'message_bus' => env('MESSAGE_BUS', 'laravel_queue'),

    'kafka' => [
        'brokers' => env('KAFKA_BROKERS', 'localhost:9092'),
        'enabled' => (bool) env('KAFKA_ENABLED', false),
    ],

    'rabbitmq' => [
        'host' => env('RABBITMQ_HOST', 'localhost'),
        'enabled' => (bool) env('RABBITMQ_ENABLED', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Search index (Adapter pattern)
    |--------------------------------------------------------------------------
    |
    | null | opensearch
    |
    */
    'search_driver' => env('SEARCH_DRIVER', 'null'),

    'opensearch' => [
        'host' => env('OPENSEARCH_HOST', 'https://localhost:9200'),
        'enabled' => (bool) env('OPENSEARCH_ENABLED', false),
    ],

];
