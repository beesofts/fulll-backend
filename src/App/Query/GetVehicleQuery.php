<?php

namespace App\App\Query;

use App\Domain\Model\Vehicle;
use App\Tests\Repository\VehicleRepositoryInMemory;

readonly class GetVehicleQuery
{
    public function __construct(
        private VehicleRepositoryInMemory $vehicleRepository,
    ) {
    }

    public function __invoke(string $plateNumber): ?Vehicle
    {
        return $this->vehicleRepository->find($plateNumber);
    }
}
