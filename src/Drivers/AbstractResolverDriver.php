<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Models\Location;

abstract class AbstractResolverDriver implements LocationDriver
{
    /**
     * @var LocationResolver
     */
    private $resolver;

    /**
     * DefaultLocationDriver constructor.
     * @param Container $container
     * @param array $config
     */
    public function __construct(Container $container, array $config)
    {
        $this->resolver = $this->makeResolver($container, $config['resolver'], $config);
    }

    /**
     * @param Container $container
     * @param string $class
     * @param array $config
     * @return LocationResolver
     */
    protected function makeResolver(Container $container, string $class, array $config): LocationResolver
    {
        return $container->make($class, ['config' => $config]);
    }

    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location
    {
        return $this->resolver->resolve($request);
    }
}
