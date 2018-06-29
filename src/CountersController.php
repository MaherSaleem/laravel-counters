<?php

namespace Maher\Counters;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maher\Counters\Facades\Counters;
use Maher\Counters\Models\Counter;

class CountersController extends Controller
{

    public function index(){
        return view('Counters::index');
    }

    //FIXME model binding in not working
    public function increment(Request $request,Counter  $counter){
        dd($counter->id);
        return Counters::increment($counter->key);
    }

    //FIXME model binding in not working
    public function decrement(Request $request, Counter $counter){
        dd($counter);
        return Counters::decrement($counter->key);
    }
}