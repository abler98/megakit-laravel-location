<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Support\Manager;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationManager as LocationMangerInterface;

class LocationManager extends Manager implements LocationMangerInterface
{
    /**
     * @param string $driver
     * @return LocationDriver
     */
    public function make(string $driver): LocationDriver
    {
        return $this->driver($driver);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'geo';
    }
}
