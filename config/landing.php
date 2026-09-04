<?php

return [
    'instansi_id' => env('LANDING_INSTANSI_ID', '6a98fe7b1ee5fceb0ae0e7fc'),
    'graphql' => [
        'endpoint' => env('GRAPHQL_ENDPOINT', 'http://localhost:8080/graphql'),
        'token' => env('LANDING_GRAPHQL_TOKEN'),
        'apps_header' => env('LANDING_APPS_HEADER', 'landing'),
        'lang' => env('LANDING_LANG', 'id'),
        'timeout' => (int) env('LANDING_GRAPHQL_TIMEOUT', 10),
        'connect_timeout' => (int) env('LANDING_GRAPHQL_CONNECT_TIMEOUT', 3),
    ],
    'payment_url' => env('LANDING_PAYMENT_URL', 'https://app.pantoo.id/hrms/billing'),
    'backend_static_path' => env('BACKEND_STATIC_PATH', '../presensi_zera_BE/static'),
    'traffic_tracking_enabled' => filter_var(
        env('LANDING_TRAFFIC_TRACKING_ENABLED', true),
        FILTER_VALIDATE_BOOL
    ),
    'cache' => [
        'enabled' => filter_var(env('LANDING_CACHE_ENABLED', true), FILTER_VALIDATE_BOOL),
        'content_ttl' => max(0, (int) env('LANDING_CONTENT_CACHE_TTL', 60)),
        'listing_ttl' => max(0, (int) env('LANDING_LISTING_CACHE_TTL', 30)),
        'detail_ttl' => max(0, (int) env('LANDING_DETAIL_CACHE_TTL', 60)),
        'subscription_ttl' => max(0, (int) env('LANDING_SUBSCRIPTION_CACHE_TTL', 5)),
        'prefix' => env('LANDING_CACHE_PREFIX', 'landing:v1'),
    ],
];
