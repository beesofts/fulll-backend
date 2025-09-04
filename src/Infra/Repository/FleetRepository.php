<?php

namespace App\Infra\Repository;

use App\Domain\Model\Fleet;

class FleetRepository
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
}
