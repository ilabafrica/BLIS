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
	    "as" => "user.login",
	    "uses" => "UserController@loginAction"
	));

	Route::any("/request", array(
	    "as"   => "user.request",
	    "uses" => "UserController@requestAction"
	));

	Route::any("/reset", array(
	    "as"   => "user.reset",
	    "uses" => "UserController@resetAction"
	));
});

Route::group(array("before" => "auth"), function()
{
	Route::resource('user', 'UserController');

    Route::get("/user/{id}/delete", array(
        "as"   => "user.delete",
        "uses" => "UserController@delete"
    ));

    Route::any("/logout", array(
        "as"   => "user.logout",
        "uses" => "UserController@logoutAction"
    ));

	Route::resource('patient', 'PatientController');

    Route::get("/patient/{id}/delete", array(
        "as"   => "patient.delete",
        "uses" => "PatientController@delete"
    ));

	Route::resource('specimentype', 'SpecimenTypeController');

    Route::get("/specimentype/{id}/delete", array(
        "as"   => "specimentype.delete",
        "uses" => "SpecimenTypeController@delete"
    ));
	
	Route::resource('test_category', 'TestCategoryController');
	
	Route::get("/test_category/{id}/delete", array(
        "as"   => "test_category.delete",
        "uses" => "TestCategoryController@delete"
    ));
	
	Route::resource('measure', 'MeasureController');
	
	Route::get("/measure/{id}/delete", array(
        "as"   => "measure.delete",
        "uses" => "MeasureController@delete"
    ));

});

