<?php

namespace App\Infra\Repository;

use App\App\Port\VehicleRepositoryPort;
use App\Domain\Model\Vehicle;
use Doctrine\ORM\EntityManagerInterface;

readonly class VehicleRepository implements VehicleRepositoryPort
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(string $plateNumber): ?Vehicle
    {
        return $this->entityManager->getRepository(Vehicle::class)->find($plateNumber);
    }

    public function save(Vehicle $vehicle): void
    {
        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();
    }
}
