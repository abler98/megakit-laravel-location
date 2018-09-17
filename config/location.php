<?php

use MegaKit\Laravel\Location\Resolvers\DefaultLocationResolver;
use MegaKit\Laravel\Location\Resolvers\NullSubdomainLocationResolver;
use MegaKit\Laravel\Location\Transformers\CountryNameTransformer;

return [

    'source' => env('LOCATION_SOURCE', 'chain'),

    'transformer' => CountryNameTransformer::class,

    'sources' => [
        'chain' => [
            'driver' => 'chain',
            'sources' => ['subdomain', 'cookie', 'geo', 'default'],
        ],
        'subdomain' => [
            'driver' => 'subdomain',
            'resolver' => NullSubdomainLocationResolver::class,
            'url' => env('APP_URL'),
        ],
        'cookie' => [
            'driver' => 'cookie',
            'name' => 'laravel_location',
        ],
        'geo' => [
            'driver' => 'geo',
            'provider' => env('LOCATION_GEO_PROVIDER', 'chain'),
            'cache' => true,
            'cache_driver' => env('LOCATION_GEO_CACHE_DRIVER'),
            'cache_lifetime' => 0,
        ],
        'default' => [
            'driver' => 'resolver',
            'resolver' => DefaultLocationResolver::class,
        ],
    ],

    'geo' => [
        'providers' => [
            'chain' => [
                'providers' => ['geocoder-php'],
            ],
            'geocoder-php' => [
                //
            ],
        ],
    ],

];
