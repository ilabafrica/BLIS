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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
/*
*	Routes for test-category
*/
Route::resource('testcategory', 'TestCategoryController');
/*
*	Routes for drugs
*/
Route::resource('drug', 'DrugController');

Route::get("/drug/{id}/delete", array(
    "as"   => "drug.delete",
    "uses" => "DrugController@delete"
));
/*
*	Routes for organism
*/
Route::resource('organism', 'OrganismController');

Route::get("/organism/{id}/delete", array(
    "as"   => "organism.delete",
    "uses" => "OrganismController@delete"
));
/*
*	Routes for tests activities
*/
Route::any("/test", array(
    "as"   => "test.index",
    "uses" => "TestController@index"
));
Route::post("/test/resultinterpretation", array(
"as"   => "test.resultinterpretation",
"uses" => "TestController@getResultInterpretation"
));
 Route::any("/test/{id}/receive", array(
    "before" => "checkPerms:receive_external_test",
    "as"   => "test.receive",
    "uses" => "TestController@receive"
));
Route::any("/test/create/{patient?}", array(
    "before" => "checkPerms:request_test",
    "as"   => "test.create",
    "uses" => "TestController@create"
));
 Route::post("/test/savenewtest", array(
    "before" => "checkPerms:request_test",
    "as"   => "test.saveNewTest",
    "uses" => "TestController@saveNewTest"
));
 Route::post("/test/acceptspecimen", array(
    "before" => "checkPerms:accept_test_specimen",
    "as"   => "test.acceptSpecimen",
    "uses" => "TestController@accept"
));
 Route::get("/test/{id}/refer", array(
    "before" => "checkPerms:refer_specimens",
    "as"   => "test.refer",
    "uses" => "TestController@showRefer"
));
Route::post("/test/referaction", array(
    "before" => "checkPerms:refer_specimens",
    "as"   => "test.referAction",
    "uses" => "TestController@referAction"
));
Route::get("/test/{id}/reject", array(
    "before" => "checkPerms:reject_test_specimen",
    "as"   => "test.reject",
    "uses" => "TestController@reject"
));
Route::post("/test/rejectaction", array(
    "before" => "checkPerms:reject_test_specimen",
    "as"   => "test.rejectAction",
    "uses" => "TestController@rejectAction"
));
 Route::post("/test/changespecimen", array(
    "before" => "checkPerms:change_test_specimen",
    "as"   => "test.changeSpecimenType",
    "uses" => "TestController@changeSpecimenType"
));
 Route::post("/test/updatespecimentype", array(
    "before" => "checkPerms:change_test_specimen",
    "as"   => "test.updateSpecimenType",
    "uses" => "TestController@updateSpecimenType"
));
Route::post("/test/start", array(
    "before" => "checkPerms:start_test",
    "as"   => "test.start",
    "uses" => "TestController@start"
));
 Route::get("/test/{test}/enterresults", array(
    "before" => "checkPerms:enter_test_results",
    "as"   => "test.enterResults",
    "uses" => "TestController@enterResults"
));
Route::get("/test/{test}/edit", array(
    "before" => "checkPerms:edit_test_results",
    "as"   => "test.edit",
    "uses" => "TestController@edit"
));
 Route::post("/test/{test}/saveresults", array(
    "before" => "checkPerms:edit_test_results",
    "as"   => "test.saveResults",
    "uses" => "TestController@saveResults"
));
Route::get("/test/{test}/viewdetails", array(
    "as"   => "test.viewDetails",
    "uses" => "TestController@viewDetails"
));
Route::any("/test/{test}/verify", array(
    "before" => "checkPerms:verify_test_results",
    "as"   => "test.verify",
    "uses" => "TestController@verify"
));
/*
*	Routes for role
*/
Route::get("authorize", array(
    "as"   => "authorize",
    "uses" => "RoleController@assign"
));
Route::post("authorize", array(
    "as"   => "authorize",
    "uses" => "RoleController@saveUserRoleAssignment"
));
Route::resource("role", "RoleController");
Route::get("/role/{id}/delete", array(
    "as"   => "role.delete",
    "uses" => "RoleController@delete"
));

/*
*	Routes for permission
*/
Route::resource("permission", "PermissionController");
/*
*	Routes for user
*/
Route::resource('user', 'UserController');
Route::get("/user/{id}/delete", array(
    "as"   => "user.delete",
    "uses" => "UserController@delete"
));
/*
*	Routes for test-type
*/
Route::resource('testtype', 'TestTypeController');
Route::get("/testtype/{id}/delete", array(
    "as"   => "testtype.delete",
    "uses" => "TestTypeController@delete"
));
/*
*	Routes for specimen-rejection
*/
Route::resource('rejection', 'RejectionController');
Route::any("/rejection/{id}/delete", array(
    "as"   => "rejection.delete",
    "uses" => "RejectionController@delete"
));
/*
*	Routes for specimen-type
*/
Route::resource('specimentype', 'SpecimenTypeController');
Route::get("/specimentype/{id}/delete", array(
    "as"   => "specimentype.delete",
    "uses" => "SpecimenTypeController@delete"
));
/*
*	Routes for patient
*/
Route::resource('patient', 'PatientController');
Route::get("/patient/{id}/delete", array(
    "as"   => "patient.delete",
    "uses" => "PatientController@delete"
));
Route::post("/patient/search", array(
    "as"   => "patient.search",
    "uses" => "PatientController@search"
));
Route::any("/patientreport", array(
    "as"   => "reports.patient.index",
    "uses" => "ReportController@loadPatients"
));
Route::any("/patientreport/{id}", array(
    "as" => "reports.patient.report", 
    "uses" => "ReportController@viewPatientReport"
));
Route::any("/patientreport/{id}/{visit}", array(
    "as" => "reports.patient.report", 
    "uses" => "ReportController@viewPatientReport"
));