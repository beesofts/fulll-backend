<?php

namespace App\Tests\Builder;

use App\Domain\Model\Vehicle;
use App\Shared\IdGenerator;

class VehicleBuilder
{
    private ?string $plateNumber = null;

    public static function new(): self
    {
        return new self();
    }

    private function __construct()
    {
    }

    public function withPlateNumber(string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;

        return $this;
    }

    public function create(): Vehicle
    {
        if (is_null($this->plateNumber)) {
            $this->plateNumber = IdGenerator::generate();
        }

        return new Vehicle($this->plateNumber);
    }
}
