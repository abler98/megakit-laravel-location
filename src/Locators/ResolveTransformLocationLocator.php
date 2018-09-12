<?php

namespace MegaKit\Laravel\Location\Locators;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Contracts\LocationLocator;
use MegaKit\Laravel\Location\Contracts\LocationResolver;
use MegaKit\Laravel\Location\Contracts\LocationTransformer;
use MegaKit\Laravel\Location\LocationNotFoundException;

class ResolveTransformLocationLocator implements LocationLocator
{
    /**
     * @var LocationResolver
     */
    private $resolver;

    /**
     * @var LocationTransformer
     */
    private $transformer;

    /**
     * ResolveTransformLocationLocator constructor.
     * @param LocationResolver $resolver
     * @param LocationTransformer $transformer
     */
    public function __construct(LocationResolver $resolver, LocationTransformer $transformer)
    {
        $this->resolver = $resolver;
        $this->transformer = $transformer;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function locate(Request $request)
    {
        if ($location = $this->transformer->transform($this->resolver->resolve($request))) {
            return $location;
        } else {
            throw new LocationNotFoundException('Can\'t resolve transformed location');
        }
    }
}
