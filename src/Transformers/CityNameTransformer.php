<?php

namespace MegaKit\Laravel\Location\Transformers;

use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\Models\Location;

class CityNameTransformer implements LocationTransformer
{
    /**
     * @param Location $location
     * @return string|null
     */
    public function transform(Location $location)
    {
        if ($location->getCity() !== null && $location->getCity()->getName() !== null) {
            return $location->getCity()->getName();
        } else {
            return null;
        }
    }
}
