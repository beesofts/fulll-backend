<?php

namespace App\App\Port;

use App\Domain\Model\Vehicle;

interface VehicleRepositoryPort
{
    public function save(Vehicle $vehicle): void;

    public function find(string $plateNumber): ?Vehicle;
}
