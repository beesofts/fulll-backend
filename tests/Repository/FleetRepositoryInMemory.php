<?php

namespace App\Tests\Repository;

use App\App\Port\FleetRepositoryPort;
use App\Domain\Model\Fleet;

class FleetRepositoryInMemory implements FleetRepositoryPort
{
    /** @var Fleet[] */
    private array $fleets = [];

    public function save(Fleet $fleet): void
    {
        $this->fleets[$fleet->getId()] = $fleet;
    }

    public function find(string $id): ?Fleet
    {
        return $this->fleets[$id] ?? null;
    }

    public function findAll(): array
    {
        return $this->fleets;
    }
}
