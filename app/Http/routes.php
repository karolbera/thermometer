<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('graph');
//});

Route::get('/', 'GraphController@index');
Route::get('/send-email', 'EmailController@sendEmail');
Route::get('/check/tooHot', 'CheckTempController@tooHot');
Route::get('/check/tooCool', 'CheckTempController@tooCool');
Route::get('/check/thermometer', 'CheckTempController@thermometer');