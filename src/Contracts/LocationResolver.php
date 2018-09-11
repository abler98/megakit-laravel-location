<?php

namespace MegaKit\Laravel\Location\Contracts;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Location;

interface LocationResolver
{
    /**
     * @param Request $request
     * @return Location
     */
    public function resolve(Request $request): Location;
}
