<?php

namespace Maher\Counters\Classes;


use Maher\Counters\Models\Counter;

class Counters
{

    public function getValue($key, $default = null){
        $counter = Counter::query()->where('key', $key)->first();
        if ($counter) {
            return $counter->value;
        } elseif (!is_null($default)) {
            return $default;
        } else {
            return '';
        }
    }

    public function setValue($key, $value){
        Counter::query()->where('key', $key)->update(['value' => $value]);
    }

    public function setStep($key, $step){
        Counter::query()->where('key', $key)->update(['step' => $step]);

    }


    public function increment($key){

        $counter = Counter::query()->where('key', $key)->first();
        if($counter){
            $counter->update(['value' => $counter->value + $counter->step]);
        }
        return $counter;
    }

    public function decrement($key){

        $counter = Counter::query()->where('key', $key)->first();
        if($counter){
            $counter->update(['value' => $counter->value - $counter->step]);
        }
        return $counter;
    }
}