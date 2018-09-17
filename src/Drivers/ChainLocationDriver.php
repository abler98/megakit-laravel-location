<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationSourceManager;
use MegaKit\Laravel\Location\Models\Location;

class ChainLocationDriver implements LocationDriver
{
    /**
     * @var LocationSourceManager
     */
    private $manager;

    /**
     * @var array
     */
    private $sources;

    /**
     * ChainLocationDriver constructor.
     * @param LocationSourceManager $manger
     * @param array $config
     */
    public function __construct(LocationSourceManager $manger, array $config)
    {
        $this->manager = $manger;
        $this->sources = $config['sources'];
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        foreach ($this->sources as $source) {
            if ($location = $this->manager->make($source)->resolve($request)) {
                return $location;
            }
        }

        return null;
    }
}
