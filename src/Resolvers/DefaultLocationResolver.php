<?php

namespace MegaKit\Laravel\Location\Resolvers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Location;
use MegaKit\Laravel\Location\LocationNotFoundException;

class DefaultLocationResolver implements LocationResolver
{
    /**
     * @param Request $request
     * @return Location|null
     * @throws LocationNotFoundException
     */
    public function resolve(Request $request): ?Location
    {
        throw new LocationNotFoundException('Can\'t resolve default location');
    }
}
