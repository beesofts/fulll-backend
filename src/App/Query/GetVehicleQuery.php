<?php

namespace App\App\Query;

use App\Domain\Model\Vehicle;
use App\App\Port\VehicleRepositoryPort;

readonly class GetVehicleQuery
{
    public function __construct(
        private VehicleRepositoryPort $vehicleRepository,
    ) {
    }

    public function __invoke(string $plateNumber): ?Vehicle
    {
        return $this->vehicleRepository->find($plateNumber);
    }
}
