<?php

namespace Maher\Counters\Models;

use Illuminate\Database\Eloquent\Model;


class Counterable extends Model
{
    protected $fillable = [
        'value',
        'counter_id',
        'counterable_id',
        'counterable_type',
    ];


    public function counter(){
        return $this->belongsTo(Counter::class);
    }
}
