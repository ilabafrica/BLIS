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
/* Routes accessible before logging in */
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

/* Routes accessible AFTER logging in */
Route::group(array("before" => "auth"), function()
{
    Route::any('/home', array(
        "as" => "user.home",
        "uses" => "UserController@homeAction"
        ));

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
	
	Route::resource('testcategory', 'TestCategoryController');
	
	Route::get("/testcategory/{id}/delete", array(
        "as"   => "testcategory.delete",
        "uses" => "TestCategoryController@delete"
    ));
	
	Route::resource('measure', 'MeasureController');
	
	Route::get("/measure/{id}/delete", array(
        "as"   => "measure.delete",
        "uses" => "MeasureController@delete"
    ));

    Route::resource('testtype', 'TestTypeController');

    Route::get("/testtype/{id}/delete", array(
        "as"   => "testtype.delete",
        "uses" => "TestTypeController@delete"
    ));

});

