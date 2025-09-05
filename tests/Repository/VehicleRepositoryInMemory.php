<?php

namespace App\Tests\Repository;

use App\App\Port\VehicleRepositoryPort;
use App\Domain\Model\Vehicle;

class VehicleRepositoryInMemory implements VehicleRepositoryPort
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
