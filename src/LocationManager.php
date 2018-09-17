<?php

namespace MegaKit\Laravel\Location;

use Closure;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationManager as LocationMangerInterface;

class LocationManager implements LocationMangerInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * The registered custom driver creators.
     *
     * @var array
     */
    private $customCreators = [];

    /**
     * LocationManager constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $driver
     * @param array $config
     * @return LocationDriver
     */
    public function make(string $driver, array $config): LocationDriver
    {
        if (array_key_exists($driver, $this->customCreators)) {
            return call_user_func($this->customCreators[$driver], $config);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * Register a custom driver creator Closure.
     *
     * @param string $driver
     * @param Closure $callback
     * @return $this
     */
    public function extend(string $driver, Closure $callback)
    {
        $this->customCreators[$driver] = $callback;

        return $this;
    }
}
