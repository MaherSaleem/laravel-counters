<?php

namespace Maher\Counters\Traits;

use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

trait HasCounter
{
    /**
     *
     */
    public static function bootHasCounter()
    {
    }


    /**
     * @return mixed
     */
    public function counters()
    {
        return $this->morphToMany(Counter::class, 'counterable')
            ->withPivot('value');
    }

    /**
     * @param $key
     * @return mixed | Counter
     */
    public function getCounter($key)
    {
        return $this->counters()->where('counters.key', $key)->first();
    }

    /**
     * @param $key
     * @return null| Counter
     */
    public function getCounterValue($key)
    {
        $counter = $this->getCounter($key);
        $value = null;
        if ($counter) {
            $value = $counter->pivot->value;
        }
        return $value;
    }

    /**
     * @param $key
     */
    public function addCounter($key, $initalValue = null)
    {
        //TODO check if the model has this $key before
        $counter = Counters::get($key);
        if ($counter) {
            $this->counters()->attach(
                $counter->id, [
                    'value' => !is_null($initalValue) ? $initalValue : $counter->initial_value
                ]
            );
        } else {
            logger("In addCounter: Counter Is not found for key $key");
        }
    }


    public function removeCounter($key){
        $counter = Counters::get($key);
        if($counter){
            $this->counters()->detach($counter->id);
        }else{
            logger("In removeCounter: Counter Is not found for key $key");
        }

    }

    public function incrementCounter($key){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' => $counter->pivot->value + $counter->step]);
        }else{
            logger("In incrementCounter: Counter Is not found for key $key");
        }

        return $counter;

    }

    public function decrementCounter($key){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' => $counter->pivot->value - $counter->step]);
        }else{
            logger("In decrementCounter: Counter Is not found for key $key");
        }

        return $counter;
    }

    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Model|Counters|null
     */
    public function resetCounter($key){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' => $counter->initial_value]);
        }else{
            logger("In resetCounter: Counter Is not found for key $key");
        }
        return $counter;
    }
}
