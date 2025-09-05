<?php

namespace App\Infra\Repository;

use App\App\Port\FleetRepositoryPort;
use App\Domain\Model\Fleet;
use Doctrine\ORM\EntityManagerInterface;

readonly class FleetRepository implements FleetRepositoryPort
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(string $id): ?Fleet
    {
        return $this->entityManager->getRepository(Fleet::class)->find($id);
    }

    public function save(Fleet $fleet): void
    {
        $this->entityManager->persist($fleet);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Fleet::class)->findAll();
    }
}
