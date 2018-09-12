Location Locator for Laravel
============================

[![Latest Stable Version](https://poser.pugx.org/megakit/laravel-location/v/stable)](https://packagist.org/packages/megakit/laravel-location)
[![Total Downloads](https://poser.pugx.org/megakit/laravel-location/downloads)](https://packagist.org/packages/megakit/laravel-location)
[![Latest Unstable Version](https://poser.pugx.org/megakit/laravel-location/v/unstable)](https://packagist.org/packages/megakit/laravel-location)
[![License](https://poser.pugx.org/megakit/laravel-location/license)](https://packagist.org/packages/megakit/laravel-location)

This library helps to quickly locate a user's location.

Installation
------------

```sh
$ composer require megakit/laravel-location
```

Configuration
-------------

```sh
$ php artisan vendor:publish --provider="MegaKit\Laravel\Location\LocationServiceProvider"
```

### Default config file

```php
<?php

use MegaKit\Laravel\Location\Resolvers\DefaultLocationResolver;
use MegaKit\Laravel\Location\Resolvers\NullSubdomainLocationResolver;
use MegaKit\Laravel\Location\Transformers\NullTransformer;

return [

    'driver' => env('LOCATION_PROVIDER', 'chain'),

    'transformer' => NullTransformer::class,

    'drivers' => [
        'chain' => [
            'drivers' => ['subdomain', 'cookie', 'geo', 'default'],
        ],
        'subdomain' => [
            'resolver' => NullSubdomainLocationResolver::class,
            'url' => env('APP_URL'),
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
            'geocoder-php' => [
                //
            ],
        ],
    ],

];
```

Usage
-----

You have a few options for use it.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationLocator;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Location;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @param LocationResolver $locationResolver
     * @return string
     */
    public function index(Request $request, LocationResolver $locationResolver)
    {
        return $locationResolver->resolve($request)->getCountry()->getName();
    }

    /**
     * @param Location $location
     * @return string
     */
    public function dependencyInjection(Location $location)
    {
        return $location->getCountry()->getName();
    }

    /**
     * @param Request $request
     * @return string
     */
    public function request(Request $request)
    {
        return $request->location()->getCountry()->getName();
    }

    /**
     * @param Container $container
     * @return string
     */
    public function container(Container $container)
    {
        return $container->make('location')->getCountry()->getName();
    }

    /**
     * @param Request $request
     * @param LocationLocator $locator
     * @return mixed
     */
    public function locate(Request $request, LocationLocator $locator)
    {
        return $locator->locate($request);
    }
}
```

License
-------

This package is released under the MIT License. See the bundled LICENSE file for details.
