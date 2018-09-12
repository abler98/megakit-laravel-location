<?php

namespace MegaKit\Laravel\Location\Providers;

use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Contracts\LocationProviderFactory;
use MegaKit\Laravel\Location\Models\Location;

class ChainLocationProvider implements LocationGeoProvider
{
    /**
     * @var LocationProviderFactory
     */
    private $providerFactory;

    /**
     * @var array
     */
    private $providers;

    /**
     * ChainLocationProvider constructor.
     * @param LocationProviderFactory $providerFactory
     * @param array $config
     */
    public function __construct(LocationProviderFactory $providerFactory, array $config)
    {
        $this->providerFactory = $providerFactory;
        $this->providers = $config['providers'];
    }

    /**
     * @param string $ip
     * @return Location|null
     */
    public function getByIp(string $ip): ?Location
    {
        foreach ($this->providers as $provider) {
            if ($location = $this->providerFactory->make($provider)->getByIp($ip)) {
                return $location;
            }
        }

        return null;
    }
}
