<?php

namespace App\App\Command;

use App\App\Exception\UserAlreadyExistsException;
use App\App\Port\UserRepositoryPort;
use App\Domain\Model\User;

readonly class CreateUserCommandHandler
{
    public function __construct(
        private UserRepositoryPort $userRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $this->failIfUserAlreadyExists($command->name);

        $user = new User($command->name);
        $this->userRepository->save($user);
    }

    private function failIfUserAlreadyExists(string $name): void
    {
        if (!is_null($this->userRepository->find($name))) {
            throw new UserAlreadyExistsException($name);
        }
    }
}
