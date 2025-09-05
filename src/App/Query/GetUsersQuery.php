<?php

namespace App\App\Query;

use App\App\Port\UserRepositoryPort;
use App\Domain\Model\User;

readonly class GetUsersQuery
{
    public function __construct(
        private UserRepositoryPort $userRepository,
    ) {
    }

    /**
     * @return User[]
     */
    public function __invoke(): array
    {
        return $this->userRepository->findAll();
    }
}
