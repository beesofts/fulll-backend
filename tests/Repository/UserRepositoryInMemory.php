<?php

namespace App\Tests\Repository;

use App\App\Port\UserRepositoryPort;
use App\Domain\Model\User;

class UserRepositoryInMemory implements UserRepositoryPort
{
    /** @var User[] */
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[$user->getName()] = $user;
    }

    public function find(string $id): ?User
    {
        return $this->users[$id] ?? null;
    }

    public function findAll(): array
    {
        return $this->users;
    }
}
