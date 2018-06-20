<?php

namespace Maher\Counters;


use App\Http\Controllers\Controller;

class CountersController extends Controller
{

    public function index(){
        return view('Counters::index');
    }
}