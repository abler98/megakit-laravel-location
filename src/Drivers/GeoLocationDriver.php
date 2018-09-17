<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationGeoProvider;
use MegaKit\Laravel\Location\Contracts\LocationProviderFactory;
use MegaKit\Laravel\Location\Models\Location;

class GeoLocationDriver implements LocationDriver
{
    /**
     * @var LocationGeoProvider
     */
    private $provider;

    /**
     * @var bool
     */
    private $cache;

    /**
     * @var CacheRepository
     */
    private $cacheRepository;

    /**
     * @var int
     */
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
        $this->cache = Arr::get($config, 'cache', false);
        $this->cacheRepository = $cacheManager->driver(Arr::get($config, 'cache_driver'));
        $this->cacheLifetime = Arr::get($config, 'cache_lifetime', 0);
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        $resolver = function () use ($request) {
            return $this->provider->getByIp($request->getClientIp());
        };

        if ($this->cache) {
            return $this->cacheRepository->remember($this->getCacheKey($request), $this->cacheLifetime, $resolver);
        } else {
            return call_user_func($resolver);
        }
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
