<?php

namespace App\App\Command;

class ParkVehicleCommand
{
    public function __construct(
        public string $vehiclePlateNumber,
        public float $latitude,
        public float $longitude,
    ) {
    }
}
