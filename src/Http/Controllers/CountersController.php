<?php

namespace Maher\Counters\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counterable;

class CountersController extends Controller
{

    public function index()
    {
        return view('Counters::index');
    }

    public function increment(Request $request, $counter_key)
    {
        $counter = Counters::get($counter_key);

        if ($counter) {
            $counter = Counters::increment($counter->key);
             return response()->json(['counter' => $counter], 200);
        }else{
            return response()->json(['counterNotFound' => true], 400);
        }
    }

    public function decrement(Request $request, $counter_key)
    {
        $counter = Counters::get($counter_key);
        if ($counter) {
            $counter = Counters::decrement($counter->key);
            return response()->json(['counter' => $counter], 200);
        }else{
            return response()->json(['counterNotFound' => true], 400);
        }
    }

    public function incrementCounterable(Request $request, $counterable_id)
    {
        $counterable = Counterable::query()->find($counterable_id);
        if($counterable){
            $counter = $counterable->counter;
            $counterable->update(['value' => $counterable->value + $counter->step]);
            return response()->json(['counterable' => $counterable], 200);
        }else{
            return response()->json(['counter Not Found' => true], 400);
        }
    }

    public function decrementCounterable(Request $request, $counterable_id)
    {
        $counterable = Counterable::query()->find($counterable_id);
        if($counterable){
            $counter = $counterable->counter;
            $counterable->update(['value' => $counterable->value + $counter->step]);
            return response()->json(['counterable' => $counterable], 200);
        }else{
            return response()->json(['counter Not Found' => true], 400);
        }
    }
}