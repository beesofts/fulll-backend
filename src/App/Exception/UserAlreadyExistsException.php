<?php

namespace App\App\Exception;

class UserAlreadyExistsException extends \Exception
{
    public function __construct(string $name)
    {
        $message = sprintf('The user %s already exists', $name);

        parent::__construct($message);
    }
}
