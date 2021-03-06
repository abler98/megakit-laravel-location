<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Models\Location;

class CookieLocationDriver implements LocationDriver
{
    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        return null;
    }
}
