<?php

namespace App\App\Port;

use App\Domain\Model\Fleet;

interface FleetRepositoryPort
{
    public function save(Fleet $fleet): void;

    public function find(string $id): ?Fleet;

    /**
     * @return Fleet []
     */
    public function findAll(): array;
}
