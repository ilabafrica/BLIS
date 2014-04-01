<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', array(
    "as" => "user/login",
    "uses" => "UserController@loginAction"
));

Route::any("/request", array(
    "as"   => "user/request",
    "uses" => "UserController@requestAction"
));

Route::any("/reset", array(
    "as"   => "user/reset",
    "uses" => "UserController@resetAction"
));
