<?php

namespace MegaKit\Laravel\Location\Transformers;

use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\Models\Location;

class CountryCodeTransformer implements LocationTransformer
{
    /**
     * @param Location $location
     * @return string|null
     */
    public function transform(Location $location)
    {
        if ($location->getCountry() !== null && $location->getCountry()->getCode() !== null) {
            return $location->getCountry()->getCode();
        } else {
            return null;
        }
    }
}
