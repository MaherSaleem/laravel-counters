<?php

namespace Maher\Counters\Exceptions;

use InvalidArgumentException;

class CounterDoesNotExist extends InvalidArgumentException
{
    public static function create(string $key)
    {
        return new static("There is no counter with key `{$key}`.");
    }

}
