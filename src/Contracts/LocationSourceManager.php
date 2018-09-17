<?php

namespace MegaKit\Laravel\Location\Contracts;

interface LocationSourceManager
{
    /**
     * @param string $name
     * @return LocationSource
     */
    public function make(string $name): LocationSource;
}
