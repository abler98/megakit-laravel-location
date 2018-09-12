<?php

namespace MegaKit\Laravel\Location\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use MegaKit\Laravel\Location\Models\Jsonable as JsonableTrait;

class City implements Arrayable, Jsonable, JsonSerializable
{
    use JsonableTrait;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var Point|null
     */
    private $coordinates;

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Point|null
     */
    public function getCoordinates(): ?Point
    {
        return $this->coordinates;
    }

    /**
     * @param Point|null $coordinates
     */
    public function setCoordinates(?Point $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'name' => $this->name,
            'coordinates' => $this->coordinates,
        ];
    }
}
