<?php

namespace App\Domain\Model;

use App\App\Exception\VehicleAlreadyRegisteredException;
use App\Shared\IteratorUtility;

class Fleet
{
    private string $id;

    private User $owner;

    /** @var Vehicle[] */
    private iterable $vehicles = [];

    public function __construct(
        string $id,
        User $owner,
    ) {
        $this->id = $id;
        $this->owner = $owner;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): iterable
    {
        return $this->vehicles;
    }

    /**
     * @param Vehicle[] $vehicles
     */
    public function setVehicles(array $vehicles): self
    {
        $this->vehicles = $vehicles;

        return $this;
    }

    /**
     * @throws VehicleAlreadyRegisteredException
     */
    public function registerVehicle(Vehicle $vehicle): self
    {
        if ($this->hasVehicle($vehicle->getPlateNumber())) {
            throw new VehicleAlreadyRegisteredException($vehicle->getPlateNumber());
        }

        IteratorUtility::iterator_add($this->vehicles, $vehicle);

        return $this;
    }

    public function hasVehicle(string $plateNumber): bool
    {
        return null !== array_find(
            iterator_to_array($this->vehicles),
            static fn (Vehicle $vehicle) => $vehicle->getPlateNumber() === $plateNumber
        );
    }

    public function removeVehicle(string $plateNumber): self
    {
        $this->vehicles = array_filter(
            iterator_to_array($this->vehicles),
            static fn (Vehicle $vehicle) => $vehicle->getPlateNumber() !== $plateNumber
        );

        return $this;
    }
}
