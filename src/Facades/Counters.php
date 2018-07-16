<?php

namespace Maher\Counters\Facades;


use Illuminate\Support\Facades\Facade;


/**
 * Class Counters
 * @package Maher\Counters\Facades
 * @method static create($key, $name, $initial_value = 0, $step = 1)
 * @method static get($key)
 * @method static getValue($key, $default = null)
 * @method static setValue($key, $value)
 * @method static setStep($key, $step)
 * @method static increment($key, $step = null)
 * @method static decrement($key, $step = null)
 * @method static reset($key)
 * @method static incrementIfNotHasCookies($key, $step = null)
 * @method static decrementIfNotHasCookies($key, $step = null)
 * @method static getIncrementUrl($key, $step = null)
 * @method static getDecrementUrl($key, $step = null)
 */
class Counters extends Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return \Maher\Counters\Classes\Counters::class;
    }
}