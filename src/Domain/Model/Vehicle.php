<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\Location;

class Vehicle
{
    private readonly string $plateNumber;

    private ?Location $location = null;

    public function __construct(
        string $plateNumber,
    ) {
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }
}
