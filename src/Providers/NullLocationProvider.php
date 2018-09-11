<?php

namespace MegaKit\Laravel\Location;

use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;

class NullLocationProvider implements LocationGeoProvider
{
    /**
     * @param string $ip
     * @return Location|null
     */
    public function getByIp(string $ip): ?Location
    {
        return null;
    }
}
