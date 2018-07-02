<?php

namespace Maher\Counters;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

class CountersController extends Controller
{

    public function index()
    {
        return view('Counters::index');
    }

    public function increment(Request $request, $counter_id)
    {
        $counter = Counter::query()->find($counter_id);

        if ($counter) {
            $counter = Counters::increment($counter->key);
             return response()->json(['counter' => $counter], 200);
        }else{
            return response()->json(['counterNotFound' => true], 400);
        }
    }

    public function decrement(Request $request, $counter_id)
    {
        $counter = Counter::query()->find($counter_id);
        if ($counter) {
            $counter = Counters::decrement($counter->key);
            return response()->json(['counter' => $counter], 200);
        }else{
            return response()->json(['counterNotFound' => true], 400);
        }
    }
}