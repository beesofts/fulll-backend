<?php

namespace App\App\Command;

readonly class RegisterVehicleCommand
{
    public function __construct(
        public string $fleetId,
        public string $vehiclePlateNumber,
    ) {
    }
}
