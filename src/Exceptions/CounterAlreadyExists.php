<?php

namespace Maher\Counters\Exceptions;

use InvalidArgumentException;

class CounterAlreadyExists extends InvalidArgumentException
{
    public static function create(String $key)
    {
        return new static("A `{$key}` counter already exists.");
    }
}
