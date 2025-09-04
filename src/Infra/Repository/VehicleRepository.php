<?php

namespace App\Infra\Repository;

use App\Domain\Model\Vehicle;

class VehicleRepository
{
    /** @var Vehicle[] */
    private array $vehicles = [];

    public function save(Vehicle $vehicle): void
    {
        $this->vehicles[$vehicle->getPlateNumber()] = $vehicle;
    }

    public function find(string $plateNumber): ?Vehicle
    {
        return $this->vehicles[$plateNumber] ?? null;
    }
}
