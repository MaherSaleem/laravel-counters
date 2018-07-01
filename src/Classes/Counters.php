<?php

namespace Maher\Counters\Classes;


use Maher\Counters\Models\Counter;

class Counters
{



    public function create($key, $name, $initial_value = 0, $step = 1){
        $value = $initial_value;
        Counter::query()->create(
            compact('key', 'name', 'initial_value', 'step', 'value')
        );

    }
    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|Counter
     */
    public function get($key){
        $counter = Counter::query()->where('key', $key)->first();
        return $counter;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null|string
     */
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

    /**
     * @param $key
     * @param $value
     */
    public function setValue($key, $value){
        Counter::query()->where('key', $key)->update(['value' => $value]);
    }

    /**
     * @param $key
     * @param $step
     */
    public function setStep($key, $step){
        Counter::query()->where('key', $key)->update(['step' => $step]);

    }


    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Model|Counters|null
     */
    public function increment($key){

        $counter = $this->get($key);
        if($counter){
            $counter->update(['value' => $counter->value + $counter->step]);
        }
        return $counter;
    }

    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Model|Counters|null
     */
    public function decrement($key){

        $counter = $this->get($key);
        if($counter){
            $counter->update(['value' => $counter->value - $counter->step]);
        }
        return $counter;
    }

    /**
     * @param $key
     * @return \Illuminate\Database\Eloquent\Model|Counters|null
     */
    public function reset($key){

        $counter = $this->get($key);
        if($counter){
            $counter->update(['value' => $counter->initial_value]);
        }
        return $counter;
    }

    public function incrementIfNotHasCookies($key){
        $cookieName = $this->getCookieName($key);
        if(!array_key_exists($cookieName, $_COOKIE)){
            $this->increment($key);
            setcookie($cookieName, 1);
        }
    }

    public function decrementIfNotHasCookies($key){
        $cookieName = $this->getCookieName($key);
        if(!array_key_exists($cookieName, $_COOKIE)){
            $this->increment($key);
            setcookie($cookieName, 1);
        }
    }

    //FIXME still buggy
    public function clearCookie($key){
        $cookieName = $this->getCookieName($key);
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName, '', time() - 3600);
    }

    private function getCookieName($key){
        return 'counters-cookie-' . $key;
    }
}