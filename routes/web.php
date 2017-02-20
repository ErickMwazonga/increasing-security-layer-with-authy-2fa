<?php

Route::get('authy/status', 'Auth\AuthyController@status');
Route::post('authy/callback', ['middleware' => 'validate_authy', 'uses'=>'Auth\AuthyController@callback']);


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');


