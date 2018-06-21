<?php

namespace Maher\Counters\Models;

use Illuminate\Database\Eloquent\Model;

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
