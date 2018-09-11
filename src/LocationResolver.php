<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationResolver as LocationResolverInterface;

class LocationResolver implements LocationResolverInterface
{
    /**
     * @var LocationDriver
     */
    private $driver;

    /**
     * LocationResolver constructor.
     * @param LocationDriver $driver
     */
    public function __construct(LocationDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param Request $request
     * @return Location
     * @throws LocationException
     */
    public function resolve(Request $request): Location
    {
        $location = $this->driver->resolve($request);

        if (null === $location) {
            throw new LocationException('Can\'t resolve location');
        }

        return $location;
    }
}
