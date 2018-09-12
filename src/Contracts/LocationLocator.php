<?php

namespace MegaKit\Laravel\Location\Contracts;

use Illuminate\Http\Request;

interface LocationLocator
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function locate(Request $request);
}
