<?php

namespace Maher\Counters\Facades;


use Illuminate\Support\Facades\Facade;


/**
 * Class Counters
 * @package Maher\Counters\Facades
 * @method static getValue($key, $default = null)
 * @method static setValue($key, $value)
 * @method static setStep($key, $step)
 * @method static increment($key)
 * @method static decrement($key)
 */
class Counters extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Maher\Counters\Classes\Counters::class;
    }
}