<?php



$baseUrl = config("counter.base_url");

/*
 * These can be used as API to increment general counters
 */
Route::get("$baseUrl/increment/{counter}", "CountersController@increment");
Route::get("$baseUrl/decrement/{counter}","CountersController@decrement");


Route::get("$baseUrl/counterable/increment/{counterable}", "CountersController@incrementCounterable");
Route::get("$baseUrl/counterable/decrement/{counterable}","CountersController@decrementCounterable");


Route::get("/$baseUrl", "CountersController@index");
