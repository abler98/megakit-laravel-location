<?php

use MegaKit\Laravel\Location\Resolvers\DefaultLocationResolver;

return [

    'driver' => env('LOCATION_PROVIDER', 'chain'),

    'drivers' => [
        'chain' => [
            'drivers' => ['subdomain', 'cookie', 'geo', 'default'],
        ],
        'subdomain' => [
            //
        ],
        'cookie' => [
            'name' => 'laravel_location',
        ],
        'geo' => [
            'provider' => env('LOCATION_GEO_PROVIDER', 'chain'),
            'cache' => true,
            'cache_driver' => env('LOCATION_GEO_CACHE_DRIVER'),
            'cache_lifetime' => 0,
        ],
        'default' => [
            'resolver' => DefaultLocationResolver::class,
        ],
    ],

    'geo' => [
        'providers' => [
            'chain' => [
                'providers' => ['geocoder-php'],
            ],
        ],
    ],

];
