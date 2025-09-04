<?php

namespace App\Shared;

class IdGenerator
{
    public static function generate(): string
    {
        return uniqid();
    }
}
