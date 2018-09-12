<?php

namespace MegaKit\Laravel\Location;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use MegaKit\Laravel\Location\Models\City;
use MegaKit\Laravel\Location\Models\Country;
use MegaKit\Laravel\Location\Models\Jsonable as JsonableTrait;

class Location implements Arrayable, Jsonable, JsonSerializable
{
    use JsonableTrait;

    /**
     * @var City|null
     */
    private $city;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @return City|null
     */
    public function getCity(): ?City
    {
        return $this->city;
    }

    /**
     * @param City|null $city
     */
    public function setCity(?City $city): void
    {
        $this->city = $city;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @param Country|null $country
     */
    public function setCountry(?Country $country): void
    {
        $this->country = $country;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
