<?php

namespace Maher\Counters\Facades;


use Illuminate\Support\Facades\Facade;

class Counters extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Maher\Counters\Classes\Counters::class;
    }
}