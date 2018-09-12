<?php

namespace MegaKit\Laravel\Location\Transformers;

use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\Models\Location;

class CountryNameTransformer implements LocationTransformer
{
    /**
     * @param Location $location
     * @return string|null
     */
    public function transform(Location $location)
    {
        if ($location->getCountry() !== null && $location->getCountry()->getName() !== null) {
            return $location->getCountry()->getName();
        } else {
            return null;
        }
    }
}
