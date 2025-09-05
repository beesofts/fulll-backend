<?php

namespace App\App\Query;

use App\App\Port\FleetRepositoryPort;
use App\Domain\Model\Fleet;

readonly class GetFleetsQuery
{
    public function __construct(
        private FleetRepositoryPort $fleetRepository,
    ) {
    }

    /**
     * @return Fleet[]
     */
    public function __invoke(): array
    {
        return $this->fleetRepository->findAll();
    }
}
