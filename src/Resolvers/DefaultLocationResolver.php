<?php

namespace MegaKit\Laravel\Location\Resolvers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Location;
use MegaKit\Laravel\Location\LocationException;

class DefaultLocationResolver implements LocationResolver
{
    /**
     * @param Request $request
     * @return Location
     * @throws LocationException
     */
    public function resolve(Request $request): Location
    {
        throw new LocationException('Can\'t resolve default location');
    }
}
