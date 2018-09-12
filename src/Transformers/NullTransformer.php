<?php

namespace MegaKit\Laravel\Location\Transformers;

use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\Models\Location;

class NullTransformer implements LocationTransformer
{
    /**
     * @param Location $location
     * @return mixed
     */
    public function transform(Location $location)
    {
        return $location;
    }
}
