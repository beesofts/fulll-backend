<?php

namespace App\App\Command;

use App\App\Exception\EntityNotFoundException;
use App\App\Exception\VehicleAlreadyParkedAtThisLocation;
use App\App\Port\VehicleRepositoryPort;
use App\Domain\Model\Vehicle;
use App\Domain\ValueObject\Location;

readonly class ParkVehicleCommandHandler
{
    public function __construct(
        private VehicleRepositoryPort $vehicleRepository,
    ) {
    }

    public function __invoke(ParkVehicleCommand $command): void
    {
        $vehicle = $this->getVehicule($command->vehiclePlateNumber);
        $location = new Location($command->latitude, $command->longitude);

        if (!is_null($vehicle->getLocation()) && $vehicle->getLocation()->equals($location)) {
            throw new VehicleAlreadyParkedAtThisLocation($vehicle, $location);
        }

        $vehicle->setLocation($location);
        $this->vehicleRepository->save($vehicle);
    }

    /**
     * @throws EntityNotFoundException
     */
    private function getVehicule(string $plateNumber): Vehicle
    {
        $vehicle = $this->vehicleRepository->find($plateNumber);

        if (is_null($vehicle)) {
            throw new EntityNotFoundException(Vehicle::class, $plateNumber, 'plateNumber');
        }

        return $vehicle;
    }
}
