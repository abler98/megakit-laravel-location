<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Support\Manager;
use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Contracts\LocationProviderFactory as Factory;

class LocationProviderFactory extends Manager implements Factory
{
    /**
     * @param string $driver
     * @return LocationGeoProvider
     */
    public function make(string $driver): LocationGeoProvider
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
        return 'null';
    }
}
