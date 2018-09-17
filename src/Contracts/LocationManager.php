<?php

namespace MegaKit\Laravel\Location\Contracts;

interface LocationManager
{
    /**
     * @param string $driver
     * @param array $config
     * @return LocationDriver
     */
    public function make(string $driver, array $config): LocationDriver;
}
