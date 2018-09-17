<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationResolver as LocationResolverInterface;
use MegaKit\Laravel\Location\Contracts\LocationSource;
use MegaKit\Laravel\Location\Models\Location;

class LocationResolver implements LocationResolverInterface
{
    /**
     * @var LocationDriver
     */
    private $source;

    /**
     * LocationResolver constructor.
     * @param LocationSource $source
     */
    public function __construct(LocationSource $source)
    {
        $this->source = $source;
    }

    /**
     * @param Request $request
     * @return Location|null
     * @throws LocationNotFoundException
     */
    public function resolve(Request $request): ?Location
    {
        $location = $this->source->resolve($request);

        if (null === $location) {
            throw new LocationNotFoundException('Can\'t resolve location');
        }

        return $location;
    }
}
