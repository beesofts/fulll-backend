<?php

namespace App\App\Exception;

use App\Domain\Model\Vehicle;
use App\Domain\ValueObject\Location;

class VehicleAlreadyParkedAtThisLocation extends \Exception
{
    public function __construct(Vehicle $vehicle, Location $location)
    {
        $message = sprintf(
            'The vehicle %s is already parked at %s %s',
            $vehicle->getPlateNumber(),
            $location->getLatitude(),
            $location->getLongitude()
        );

        parent::__construct($message);
    }
}
