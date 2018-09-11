<?php

namespace MegaKit\Laravel\Location\Contracts;

interface LocationManager
{
    /**
     * @param string $driver
     * @return LocationDriver
     */
    public function make(string $driver): LocationDriver;
}
