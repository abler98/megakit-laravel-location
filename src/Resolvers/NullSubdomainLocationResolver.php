<?php

namespace MegaKit\Laravel\Location\Resolvers;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Location;

class NullSubdomainLocationResolver extends SubdomainLocationResolver
{
    /**
     * @param Request $request
     * @param string $subdomain
     * @return Location|null
     */
    protected function findBySubdomain(Request $request, string $subdomain): ?Location
    {
        return null;
    }
}
