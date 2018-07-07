<?php

namespace Maher\Counters\Traits;

use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

/**
 * Trait HasCounter
 * @package Maher\Counters\Traits
 */
trait HasCounter
{


    /**
     * @return mixed
     * The morph relation between any model and counters
     */
    public function counters()
    {
        $counterableTableName = config('counter.counterable.table_name');
        return $this->morphToMany(
            Counter::class,
            'counterable',
                $counterableTableName
            )
            ->withPivot('value', 'id');
    }

    /**
     * @param $key
     * @return mixed
     * Get counter related to the relation with the given $key
     */
    public function getCounter($key)
    {
        $countersTable = config('counter.counter.table_name');
        $counter = $this->counters()->where("$countersTable.key", $key)->first();
        //connect the counter to the object if it's not exist
        if(!$counter){
            $this->addCounter($key);
            $counter = $this->counters()->where("$countersTable.key", $key)->first();
        }
        return $counter;
    }

    /**
     * @param $key
     * @return bool
     * check if the related model has counter with the given key
     */
    public function hasCounter($key){
        $countersTable = config('counter.counter.table_name');
        return !is_null($this->counters()->where("$countersTable.key", $key)->first());
    }

    /**
     * @param $key
     * @return null
     * Get the related model value of the counter for the given $key
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
     * @param null $initialValue
     * Add a record to counterable table (make relation with the given $key)
     */
    public function addCounter($key, $initialValue = null)
    {
        $counter = Counters::get($key);
        if ($counter) {
            if(!$this->hasCounter($key)){ // not to add the counter twice
                $this->counters()->attach(
                    $counter->id, [
                        'value' => !is_null($initialValue) ? $initialValue : $counter->initial_value
                    ]
                );
            }else{
                logger("In addCounter: This object already has counter for $key");
            }
        } else {
            logger("In addCounter: Counter Is not found for key $key");
        }
    }


    /**
     * @param $key
     * Remove the relation in counterable table
     */
    public function removeCounter($key){
        $counter = Counters::get($key);
        if($counter){
            $this->counters()->detach($counter->id);
        }else{
            logger("In removeCounter: Counter Is not found for key $key");
        }

    }

    /**
     * @param $key
     * @return mixed
     * Increment the counterable in the relation table for the given $key
     */
    public function incrementCounter($key, $step = null){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' => $counter->pivot->value + ($step ?? $counter->step)]);
        }else{
            logger("In incrementCounter: Counter Is not found for key $key");
        }

        return $counter;

    }

    /**
     * @param $key
     * @return mixed
     * Decrement the counterable in the relation table for the given $key
     */
    public function decrementCounter($key, $step = null){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' => $counter->pivot->value - ($step ?? $counter->step)]);
        }else{
            logger("In decrementCounter: Counter Is not found for key $key");
        }

        return $counter;
    }

    /**
     * @param $key
     * @return mixed
     * Reset the counterable in the relation table to the initial value for the given $key
     */
    public function resetCounter($key ,$initalVlaue = null){
        $counter = $this->getCounter($key);
        if($counter){
            $this->counters()->updateExistingPivot($counter->id, ['value' =>$initalVlaue ?? $counter->initial_value]);
        }else{
            logger("In resetCounter: Counter Is not found for key $key");
        }
        return $counter;
    }

    /**
     * @param $key
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getIncrementUrl($key){
        $counter = $this->getCounter($key);
        if($counter){
            $counterableId = $counter->pivot->id;
            $countersBaseUrl = config('counter.base_url');
            return url("$countersBaseUrl/counterable/increment/" . $counterableId);
        }else{
            return '#';
        }
    }

    /**
     * @param $key
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getDecrementUrl($key){
        $counter = $this->getCounter($key);
        if($counter){
            $counterableId = $counter->pivot->id;
            $countersBaseUrl = config('counter.base_url');
            return url("$countersBaseUrl/counterable/decrement/" . $counterableId);
        }else{
            return '#';
        }
    }
}
