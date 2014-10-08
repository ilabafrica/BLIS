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
    /*
    |-----------------------------------------
    | API route
    |-----------------------------------------
    | Proposed route for the BLIS api, we will receive api calls 
    | from other systems from this route.
    */
    Route::get('/api/receiver', array(
        "as" => "api.receiver",
        "uses" => "interfacerController@receiveLabrequest"
    ));

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

    Route::group(array("before" => "checkPerms:manage_users"), function()
    {
    	Route::resource('user', 'UserController');

        Route::get("/user/{id}/delete", array(
            "as"   => "user.delete",
            "uses" => "UserController@delete"
        ));
    });
    
    Route::any("/logout", array(
        "as"   => "user.logout",
        "uses" => "UserController@logoutAction"
    ));

	Route::resource('patient', 'PatientController');

    Route::get("/patient/{id}/delete", array(
        "as"   => "patient.delete",
        "uses" => "PatientController@delete"
    ));

    Route::post("/patient/search", function(){

        return Patient::select('id', 'patient_number','name')
                ->where(function($query){
                    $txt = Input::get('text');
                    $query->where("name", "LIKE", "%".$txt."%")
                        ->orWhere("patient_number", "LIKE", "%".$txt."%");
                })->get()->toJson();
    });

    Route::group(array("before" => "checkPerms:manage_test_catalog"), function()
    {
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
    /*Route::resource('test', 'TestController');*/

    Route::any("/test", array(
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

    Route::any("/test/create/{patient?}", array(
        "as"   => "test.create",
        "uses" => "TestController@create"
    ));

    Route::group(array("before" => "admin"), function()
    {
        Route::resource("permission", "PermissionController");

        Route::get("role/assign", array(
            "as"   => "role.assign",
            "uses" => "RoleController@assign"
        ));
        Route::post("role/assign", array(
            "as"   => "role.assign",
            "uses" => "RoleController@saveUserRoleAssignment"
        ));
        Route::resource("role", "RoleController");

        Route::get("/role/{id}/delete", array(
            "as"   => "role.delete",
            "uses" => "RoleController@delete"
        ));
    });
    Route::get("/test/{test}/getteststatus", array(
        "as"   => "test.getTestStatus",
        "uses" => "TestController@getTestStatusById"
    ));
});

// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
        Log::info($query);
});

//TO DO: move events to app/events.php or somewhere else
Event::listen('api.receivedLabrequest', function($labRequest)
{
    //We instruct the interfacer to handle the request
    $interfacer = App::make('interfacer');
    $interfacer->get($labRequest);

});