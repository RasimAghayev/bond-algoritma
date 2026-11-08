<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => explode(',', (string) env('CORS_ALLOWED_METHODS', 'GET,POST,PUT,PATCH,DELETE,OPTIONS')),

    'allowed_origins' => array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGINS', 'http://localhost,http://localhost:20100'))))),

    'allowed_origins_patterns' => array_values(array_filter(array_map('trim', explode(',', (string) env('CORS_ALLOWED_ORIGIN_PATTERNS', ''))))),

    'allowed_headers' => explode(',', (string) env('CORS_ALLOWED_HEADERS', 'Content-Type,Authorization,X-Requested-With,Accept,Origin')),

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
