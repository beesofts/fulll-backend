<?php

namespace App\App\Command;

use App\App\Exception\EntityNotFoundException;
use App\Domain\Model\Fleet;
use App\Domain\Model\Vehicle;
use App\Infra\Repository\FleetRepository;
use App\Infra\Repository\VehicleRepository;

readonly class RegisterVehicleCommandHandler
{
    public function __construct(
        private VehicleRepository $vehicleRepository,
        private FleetRepository $fleetRepository,
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
