<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationManager;
use MegaKit\Laravel\Location\Models\Location;

class ChainLocationDriver implements LocationDriver
{
    /**
     * @var LocationManager
     */
    private $manager;

    /**
     * @var array
     */
    private $drivers;

    /**
     * ChainLocationDriver constructor.
     * @param LocationManager $manger
     * @param array $config
     */
    public function __construct(LocationManager $manger, array $config)
    {
        $this->manager = $manger;
        $this->drivers = $config['drivers'];
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        foreach ($this->drivers as $driver) {
            if ($location = $this->manager->make($driver)->resolve($request)) {
                return $location;
            }
        }

        return null;
    }
}
