<?php

namespace App\App\Command;

class CreateUserCommand
{
    public function __construct(
        public string $name,
    ) {
    }
}
