<?php

namespace App\App\Port;

use App\Domain\Model\User;

interface UserRepositoryPort
{
    public function save(User $user): void;

    public function find(string $id): ?User;

    /**
     * @return User[]
     */
    public function findAll(): array;
}
