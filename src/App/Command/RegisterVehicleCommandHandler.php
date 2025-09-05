<?php

namespace App\App\Command;

use App\App\Exception\EntityNotFoundException;
use App\App\Port\FleetRepositoryPort;
use App\App\Port\VehicleRepositoryPort;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;

readonly class RegisterVehicleCommandHandler
{
    public function __construct(
        private VehicleRepositoryPort $vehicleRepository,
        private FleetRepositoryPort $fleetRepository,
    ) {
    }

    public function __invoke(RegisterVehicleCommand $command): void
    {
        $fleet = $this->getFleet($command->fleetId);
        $vehicle = $this->getOrCreateVehicle($command->vehiclePlateNumber);

        $fleet->registerVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }

    /**
     * @throws EntityNotFoundException
     */
    private function getFleet(string $id): Fleet
    {
        $fleet = $this->fleetRepository->find($id);

        if (is_null($fleet)) {
            throw new EntityNotFoundException(Fleet::class, $id);
        }

        return $fleet;
    }

    private function getOrCreateVehicle(string $plateNumber): Vehicle
    {
        $vehicle = $this->vehicleRepository->find($plateNumber);

        if (is_null($vehicle)) {
            $vehicle = new Vehicle($plateNumber);
            $this->vehicleRepository->save($vehicle);
        }

        return $vehicle;
    }
}
