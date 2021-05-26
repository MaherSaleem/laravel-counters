<?php

namespace Maher\Counters\Models;

use Illuminate\Database\Eloquent\Model;
use Maher\Counters\Facades\Counters;


/**
 * Class Counter
 * @package Maher\Counters\Models
 * @property int id
 * @property string key
 * @property string name
 * @property double value
 * @property double initial_value
 * @property double step
 */
class Counter extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'name',
        'value',
        'initial_value',
        'step',
    ];

    public function getIncrementUrl(){
        return Counters::getIncrementUrl($this->key);
    }

    public function getDecrementUrl(){
        return Counters::getDecrementUrl($this->key);
    }

}
