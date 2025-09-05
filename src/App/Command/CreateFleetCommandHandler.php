<?php

namespace App\App\Command;

use App\App\Exception\EntityNotFoundException;
use App\App\Port\FleetRepositoryPort;
use App\App\Port\UserRepositoryPort;
use App\Domain\Model\Fleet;
use App\Domain\Model\User;
use App\Shared\IdGenerator;

readonly class CreateFleetCommandHandler
{
    public function __construct(
        private FleetRepositoryPort $fleetRepository,
        private UserRepositoryPort $userRepository,
    ) {
    }

    public function __invoke(CreateFleetCommand $command): string
    {
        $user = $this->getUserOrFail($command->userName);
        $fleetId = IdGenerator::generate();
        $fleet = new Fleet($fleetId, $user);
        $this->fleetRepository->save($fleet);

        return $fleetId;
    }

    /**
     * @throws EntityNotFoundException
     */
    private function getUserOrFail(string $userName): User
    {
        $user = $this->userRepository->find($userName);

        if (is_null($user)) {
            throw new EntityNotFoundException(User::class, $userName, 'name');
        }

        return $user;
    }
}
