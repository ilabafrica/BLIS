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

    Route::get("/specimentype/{specimen}/delete", array(
        "as"   => "specimentype.delete",
        "uses" => "SpecimenTypeController@delete"
    ));
    
    /**
     * Get TestTypes available for this SpecimenType.
     */
    Route::get("/specimentype/{specimen}/testtypes", function($id){
        return SpecimenType::find($id)->testTypes;
    });
    
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

    /*Route::resource('test', 'TestController');*/

    Route::get("/test", array(
        "as"   => "test.index",
        "uses" => "TestController@index"
    ));

    Route::get("/test/{id}/reject", array(
        "as"   => "test.reject",
        "uses" => "TestController@reject"
    ));

    Route::get("/test/{id}/rejectaction", array(
        "as"   => "test.rejectAction",
        "uses" => "TestController@rejectAction"
    ));

    Route::get("/test/{test}/start", array(
        "as"   => "test.start",
        "uses" => "TestController@start"
    ));

     Route::get("/test/{test}/enterresults", array(
        "as"   => "test.enterResults",
        "uses" => "TestController@enterResults"
    ));

     Route::post("/test/savenewtest", array(
        "as"   => "test.saveNewTest",
        "uses" => "TestController@saveNewTest"
    ));

     Route::post("/test/{test}/saveresults", array(
        "as"   => "test.saveResults",
        "uses" => "TestController@saveResults"
    ));

    Route::get("/test/{test}/viewdetails", array(
        "as"   => "test.viewDetails",
        "uses" => "TestController@viewDetails"
    ));

    Route::get("/test/{test}/edit", array(
        "as"   => "test.edit",
        "uses" => "TestController@edit"
    ));

    Route::get("/test/verify", array(
        "as"   => "test.verify",
        "uses" => "TestController@verify"
    ));

    Route::get("/test/{patient}/create", array(
        "as"   => "test.create",
        "uses" => "TestController@create"
    ));

});

// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
        Log::info($query);
});