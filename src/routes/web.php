<?php




/*
 * These are apis for ajax uses
 */
Route::get('counters/increment/{counter}', 'CountersController@increment');
Route::get('counters/decrement/{counter}','CountersController@decrement');


Route::get('/counters', 'CountersController@index');
