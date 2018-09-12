<?php

namespace MegaKit\Laravel\Location\Contracts;

use MegaKit\Laravel\Location\Models\Location;

interface LocationTransformer
{
    /**
     * @param Location $location
     * @return mixed
     */
    public function transform(Location $location);
}
