<?php

namespace MegaKit\Laravel\Location\Providers;

use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Models\Location;

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
