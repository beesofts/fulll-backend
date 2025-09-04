<?php

namespace App\App\Exception;

class EntityNotFoundException extends \Exception
{
    public function __construct(string $classname, string $value, string $field = 'id')
    {
        $message = sprintf('The %s with %s %s was not found', $classname, $field, $value);

        parent::__construct($message);
    }
}
