<?php

namespace App\Tests\Builder;

use App\Domain\Model\User;

class UserBuilder
{
    private ?string $name = null;

    public static function new(): self
    {
        return new self();
    }

    private function __construct()
    {
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function create(): User
    {
        if (is_null($this->name)) {
            $this->name = 'John Doe ' . uniqid();
        }

        return new User($this->name);
    }
}
