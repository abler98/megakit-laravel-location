<?php

namespace MegaKit\Laravel\Location\Contracts;

use MegaKit\Laravel\Location\Location;

interface LocationTransformer
{
    /**
     * @param Location $location
     * @return mixed
     */
    public function transform(Location $location);
}
