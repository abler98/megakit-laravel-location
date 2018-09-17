<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Support\Manager;
use MegaKit\Laravel\Location\Contracts\LocationSource;
use MegaKit\Laravel\Location\Contracts\LocationSourceManager as LocationSourceManagerInterface;

class LocationSourceManager extends Manager implements LocationSourceManagerInterface
{
    /**
     * @param string $name
     * @return LocationSource
     */
    public function make(string $name): LocationSource
    {
        return $this->driver($name);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return null;
    }
}
