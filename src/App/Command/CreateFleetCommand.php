<?php

namespace App\App\Command;

class CreateFleetCommand
{
    public function __construct(
        public string $userName,
    ) {
    }
}
