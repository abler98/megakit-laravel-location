<?php

namespace MegaKit\Laravel\Location\Contracts;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Location;

interface LocationDriver
{
    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location;
}
