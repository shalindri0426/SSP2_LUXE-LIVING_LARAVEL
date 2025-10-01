<?php

return [
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'livewire/update',
        'livewire/livewire.js',
        'livewire/livewire.min.js',
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [env('APP_URL', 'http://localhost')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];