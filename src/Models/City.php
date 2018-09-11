<?php

namespace MegaKit\Laravel\Location\Models;

class City
{
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
}
