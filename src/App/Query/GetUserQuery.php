<?php

namespace App\App\Query;

use App\App\Port\UserRepositoryPort;
use App\Domain\Model\User;

readonly class GetUserQuery
{
    public function __construct(
        private UserRepositoryPort $userRepository,
    ) {
    }

    public function __invoke(string $name): ?User
    {
        return $this->userRepository->find($name);
    }
}
