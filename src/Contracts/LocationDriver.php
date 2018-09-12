<?php

namespace MegaKit\Laravel\Location\Contracts;

use Illuminate\Http\Request;
use MegaKit\Laravel\Location\Models\Location;

interface LocationDriver
{
    /**
     * @param Request $request
     * @return Location|null
     */
    public function resolve(Request $request): ?Location;
}
