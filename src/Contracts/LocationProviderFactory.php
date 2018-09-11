<?php

namespace MegaKit\Laravel\Location\Contracts;

interface LocationProviderFactory
{
    /**
     * @param string $driver
     * @return LocationGeoProvider
     */
    public function make(string $driver): LocationGeoProvider;
}
