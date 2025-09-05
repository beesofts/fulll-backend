<?php

namespace App\App\Query;

use App\App\Port\FleetRepositoryPort;
use App\Domain\Model\Fleet;

readonly class GetFleetQuery
{
    public function __construct(
        private FleetRepositoryPort $fleetRepository,
    ) {
    }

    public function __invoke(string $id): ?Fleet
    {
        return $this->fleetRepository->find($id);
    }
}
