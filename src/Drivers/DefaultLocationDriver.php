<?php

namespace MegaKit\Laravel\Location\Drivers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationDriver;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Location;

class DefaultLocationDriver implements LocationDriver
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
        $this->resolver = $container->make($config['resolver']);
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
