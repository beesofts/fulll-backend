<?php

namespace App\Infra\Repository;

use App\App\Port\UserRepositoryPort;
use App\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class UserRepository implements UserRepositoryPort
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function find(string $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(User::class)->findAll();
    }
}
