<?php

namespace MegaKit\Laravel\Location\Contracts;

use MegaKit\Laravel\Location\Location;

interface LocationGeoProvider
{
    /**
     * @param string $ip
     * @return Location|null
     */
    public function getByIp(string $ip): ?Location;
}
