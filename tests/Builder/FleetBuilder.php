<?php

namespace App\Tests\Builder;

use App\Domain\Model\Fleet;
use App\Domain\Model\User;
use App\Domain\Model\Vehicle;
use App\Shared\IdGenerator;

class FleetBuilder
{
    private ?string $id = null;

    private ?User $owner = null;

    /** @var Vehicle[] */
    private array $vehicles = [];

    public static function new(): self
    {
        return new self();
    }

    private function __construct()
    {
    }

    public function withId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withVehicle(Vehicle $vehicle): self
    {
        $this->vehicles[] = $vehicle;

        return $this;
    }

    public function create(): Fleet
    {
        if (is_null($this->id)) {
            $this->id = IdGenerator::generate();
        }
        if (is_null($this->owner)) {
            $this->owner = UserBuilder::new()->create();
        }

        $fleet = new Fleet($this->id, $this->owner);
        foreach ($this->vehicles as $vehicle) {
            $fleet->registerVehicle($vehicle);
        }

        return $fleet;
    }
}
