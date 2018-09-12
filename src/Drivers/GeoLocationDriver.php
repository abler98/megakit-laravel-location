<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Contracts\LocationProviderFactory;
use MegaKit\Laravel\Location\Location;

class GeoLocationDriver implements LocationDriver
{
    /**
     * @var LocationGeoProvider
     */
    private $provider;

    /**
     * @var CacheRepository
     */
    private $cache;

    private $cacheLifetime;

    /**
     * GeoLocationDriver constructor.
     * @param LocationProviderFactory $providerFactory
     * @param CacheManager $cacheManager
     * @param array $config
     */
    public function __construct(LocationProviderFactory $providerFactory, CacheManager $cacheManager, array $config)
    {
        $this->provider = $providerFactory->make($config['provider']);
        $this->cache = $cacheManager->driver(Arr::get($config, 'cache_driver'));
        $this->cacheLifetime = Arr::get($config, 'cache_lifetime', 0);
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        return $this->cache->remember($this->getCacheKey($request), $this->cacheLifetime, function () use ($request) {
            return $this->provider->getByIp($request->getClientIp());
        });
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getCacheKey(Request $request): string
    {
        return sprintf('megakit.laravel.location.geo:%s', $request->getClientIp());
    }
}
