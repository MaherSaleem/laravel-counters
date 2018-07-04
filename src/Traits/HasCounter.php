<?php

namespace Maher\Counters\Traits;

use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

trait HasCounter
{



    /**
     * @return mixed
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
     * @return mixed | Counter
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

    public function hasCounter($key){
        $countersTable = config('counter.counter.table_name');
        return !is_null($this->counters()->where("$countersTable.key", $key)->first());
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
        $counter = Counters::get($key);
        if ($counter) {
            if(!$this->hasCounter($key)){ // not to add the counter twice
                $this->counters()->attach(
                    $counter->id, [
                        'value' => !is_null($initalValue) ? $initalValue : $counter->initial_value
                    ]
                );
            }else{
                logger("In addCounter: This object already has counter for $key");
            }
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
