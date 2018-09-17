<?php

namespace MegaKit\Laravel\Location\Sources;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MegaKit\Laravel\Location\Contracts\LocationManager;
use MegaKit\Laravel\Location\Contracts\LocationSource;
use MegaKit\Laravel\Location\Models\Location;

class DriverLocationSource implements LocationSource
{
    /**
     * @var LocationManager
     */
    private $locationManager;

    /**
     * @var array
     */
    private $config;

    /**
     * DriverLocationSource constructor.
     * @param LocationManager $locationManager
     * @param array $config
     */
    public function __construct(LocationManager $locationManager, array $config)
    {
        $this->locationManager = $locationManager;
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        $configDriver = Arr::except($this->config, 'driver');

        return $this->locationManager->make($this->config['driver'], $configDriver)->resolve($request);
    }
}
