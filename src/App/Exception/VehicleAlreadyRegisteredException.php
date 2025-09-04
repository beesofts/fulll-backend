<?php

namespace App\App\Exception;

class VehicleAlreadyRegisteredException extends \Exception
{
    public function __construct(string $plateNumber)
    {
        $message = sprintf('The vehicle %s is already registered', $plateNumber);

        parent::__construct($message);
    }
}
