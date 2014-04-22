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

Route::group(array("before" => "guest"), function()
{
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

	Route::resource('patient', 'PatientController');
});

Route::group(array("before" => "auth"), function()
{
    Route::any("/profile", array(
        "as"   => "user/profile",
        "uses" => "UserController@profileAction"
    ));

    Route::any("/logout", array(
        "as"   => "user/logout",
        "uses" => "UserController@logoutAction"
    ));
});

