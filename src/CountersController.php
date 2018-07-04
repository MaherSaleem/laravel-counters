<?php

namespace Maher\Counters;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

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

    public function incrementCounterable(Request $request, $counterable_key){

        //TODO implement this
    }
    public function decrementCounterable(Request $request, $counterable_key){

    }
}