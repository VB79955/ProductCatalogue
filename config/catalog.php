<?php

return [

    'provider' => env('CATALOG_PROVIDER', 'fakestore'),

    'fakestore' => [
        'base_url' => env('FAKESTORE_BASE_URL', 'https://fakestoreapi.com'),
    ],

    'cache_ttl' => (int) env('CATALOG_CACHE_TTL', 3600),

    'featured_limit' => (int) env('CATALOG_FEATURED_LIMIT', 5),

];
