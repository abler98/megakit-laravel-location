<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use MegaKit\Laravel\Location\Contracts\LocationDriver as LocationDriverInterface;
use MegaKit\Laravel\Location\Contracts\LocationLocator;
use MegaKit\Laravel\Location\Contracts\LocationManager as LocationManagerInterface;
use MegaKit\Laravel\Location\Contracts\LocationProviderFactory as LocationProviderFactoryInterface;
use MegaKit\Laravel\Location\Contracts\LocationResolver as LocationResolverInterface;
use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\Drivers\ChainLocationDriver;
use MegaKit\Laravel\Location\Drivers\CookieLocationDriver;
use MegaKit\Laravel\Location\Drivers\DefaultLocationDriver;
use MegaKit\Laravel\Location\Drivers\GeoLocationDriver;
use MegaKit\Laravel\Location\Drivers\SubdomainLocationDriver;
use MegaKit\Laravel\Location\Locators\ResolveTransformLocationLocator;
use MegaKit\Laravel\Location\Models\Location;
use MegaKit\Laravel\Location\Providers\ChainLocationProvider;
use MegaKit\Laravel\Location\Providers\GeocoderLocationProvider;

class LocationServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $drivers = [
        'chain' => ChainLocationDriver::class,
        'subdomain' => SubdomainLocationDriver::class,
        'cookie' => CookieLocationDriver::class,
        'geo' => GeoLocationDriver::class,
        'default' => DefaultLocationDriver::class,
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'location' => Location::class,
        'location.manager' => LocationManagerInterface::class,
        'location.driver' => LocationDriverInterface::class,
        'location.geo.factory' => LocationProviderFactoryInterface::class,
        'location.resolver' => LocationResolverInterface::class,
        'location.locator' => LocationLocator::class,
        'location.transformer' => LocationTransformer::class,
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerRequestMacros();
        $this->registerDrivers();
        $this->registerGeoProviders();

        $this->publishes([__DIR__.'/../config/location.php' => config_path('location.php')], 'laravel-location');
    }

    /**
     * @return void
     */
    protected function registerRequestMacros(): void
    {
        $app = $this->app;

        Request::macro('location', function () use ($app) {
            /** @var Request $this */
            return $app->make('location.resolver')->resolve($this);
        });
    }

    /**
     * @return void
     */
    protected function registerDrivers(): void
    {
        $manager = $this->app->make(LocationManager::class);

        foreach ($this->drivers as $name => $class) {
            $manager->extend($name, function () use ($name, $class) {
                return $this->app->make($class, [
                    'name' => $name,
                    'config' => $this->app->make('config')->get("location.drivers.$name"),
                ]);
            });
        }
    }

    /**
     * @return void
     */
    protected function registerGeoProviders(): void
    {
        $factory = $this->app->make(LocationProviderFactory::class);

        $factory->extend('null', function () {
            return new NullLocationProvider();
        });

        $factory->extend('chain', function () {
            return new ChainLocationProvider(
                $this->app->make('location.geo.factory'),
                $this->app->make('config')->get('location.geo.providers.chain')
            );
        });

        $factory->extend('geocoder-php', function () {
            return new GeocoderLocationProvider($this->app->make('geocoder'));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerServices();
        $this->registerSimpleServices();
        $this->registerAliases();
        $this->registerSubstitute();

        $this->mergeConfigFrom(__DIR__.'/../config/location.php', 'location');
    }

    /**
     * @return void
     */
    protected function registerServices(): void
    {
        $this->app->singleton(LocationProviderFactory::class, function () {
            return new LocationProviderFactory($this->app->make(Application::class));
        });

        $this->app->singleton(LocationManager::class, function () {
            return new LocationManager($this->app->make(Application::class));
        });

        $this->app->singleton(LocationDriverInterface::class, function () {
            return $this->app->make('location.manager')->make(
                $this->app->make('config')->get('location.driver')
            );
        });

        $this->app->singleton(LocationTransformer::class, function () {
            return $this->app->make($this->app->make('config')->get('location.transformer'));
        });
    }

    /**
     * @return void
     */
    protected function registerSimpleServices()
    {
        $this->app->singleton(LocationManagerInterface::class, LocationManager::class);
        $this->app->singleton(LocationProviderFactoryInterface::class, LocationProviderFactory::class);
        $this->app->singleton(LocationResolverInterface::class, LocationResolver::class);
        $this->app->singleton(LocationLocator::class, ResolveTransformLocationLocator::class);
    }

    /**
     * @return void
     */
    protected function registerSubstitute()
    {
        $this->app->bind(Location::class, function () {
            return $this->app->make('location.resolver')->resolve($this->app->make('request'));
        });
    }

    /**
     * @return void
     */
    protected function registerAliases(): void
    {
        foreach ($this->aliases as $alias => $abstract) {
            $this->app->alias($abstract, $alias);
        }
    }
}
