<?php

namespace Maher\Counters\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Counter
 * @package Maher\Counters\Models
 * @property int id
 * @property string key
 * @property string name
 * @property double value
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
        'step',
    ];
}
