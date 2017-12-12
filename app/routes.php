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
    Route::post('/api/receiver', array(
        "as" => "api.receiver",
        "uses" => "InterfacerController@receiveLabRequest"
    ));
    Route::post('/api/testinfo', array(
        "uses" => "InterfacerController@getTestInfo"
    ));
    Route::post('/api/searchtests', array(
        "uses" => "InterfacerController@getTests"
    ));
    Route::post('/api/saveresults', array(
        "uses" => "InterfacerController@saveTestResults"
    ));
    Route::any('/', array(
        "as" => "user.login",
        "uses" => "UserController@loginAction"
    ));
    
});

/* Routes accessible AFTER logging in */
Route::group(array("before" => "auth"), function()
{
    Route::any('/home', array(
        "as" => "user.home",
        "uses" => "UserController@homeAction"
        ));
    Route::group(array("before" => "checkPerms:manage_users"), function() {
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
    Route::any('/user/{id}/updateown', array(
        "as" => "user.updateOwnPassword",
        "uses" => "UserController@updateOwnPassword"
        ));
    Route::resource('patient', 'PatientController');
    Route::get("/patient/{id}/delete", array(
        "as"   => "patient.delete",
        "uses" => "PatientController@delete"
    ));
    Route::post("/patient/search", array(
        "as"   => "patient.search",
        "uses" => "PatientController@search"
    ));
    Route::any("/instrument/getresult", array(
        "as"   => "instrument.getResult",
        "uses" => "InstrumentController@getTestResult"
    ));
    Route::any("/instrument/getcontrolresult", array(
        "as"   => "instrument.getControlResult",
        "uses" => "InstrumentController@getControlResult"
    ));
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
        Route::post("/measure/{id}/reorder", array(
            "as"   => "measure.reorder",
            "uses" => "MeasureController@reorder"
        ));
        Route::resource('testtype', 'TestTypeController');
        Route::get("/testtype/{id}/delete", array(
            "as"   => "testtype.delete",
            "uses" => "TestTypeController@delete"
        ));
        Route::resource('specimenrejection', 'SpecimenRejectionController');
        Route::any("/specimenrejection/{id}/delete", array(
            "as"   => "specimenrejection.delete",
            "uses" => "SpecimenRejectionController@delete"
        ));
        Route::resource('drug', 'DrugController');
        
        Route::get("/drug/{id}/delete", array(
            "as"   => "drug.delete",
            "uses" => "DrugController@delete"
        ));
        Route::resource('organism', 'OrganismController');
        
        Route::get("/organism/{id}/delete", array(
            "as"   => "organism.delete",
            "uses" => "OrganismController@delete"
        ));
        Route::resource('critical', 'CriticalController');
        
        Route::get("/critical/{id}/delete", array(
            "as"   => "critical.delete",
            "uses" => "CriticalController@delete"
        ));

        Route::resource('microcritical', 'MicroCriticalController');
        
        Route::get("/microcritical/{id}/delete", array(
            "as"   => "microcritical.delete",
            "uses" => "MicroCriticalController@delete"
        ));
    });
    Route::group(array("before" => "checkPerms:manage_lab_configurations"), function()
    {
        Route::resource('instrument', 'InstrumentController');
        Route::get("/instrument/{id}/delete", array(
            "as"   => "instrument.delete",
            "uses" => "InstrumentController@delete"
        ));
        Route::any("/instrument/importdriver", array(
            "as"   => "instrument.importDriver",
            "uses" => "InstrumentController@importDriver"
        ));
        Route::get("/requireverification", array(
            "as"   => "requireverification.edit",
            "uses" => "RequireVerificationController@edit"
        ));

        Route::put("/requireverification", array(
            "as"   => "requireverification.update",
            "uses" => "RequireVerificationController@update"
        ));
        Route::resource('panel', 'PanelController');
        Route::get("/panel/{id}/delete",array(
            "as" =>"panel.delete",
            "uses" =>"PanelController@deactivate"
            ));
    });    
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
    Route::any("/culture/storeObservation", array(
        "as"   => "culture.worksheet",
        "uses" => "CultureController@store"
    ));
    Route::any("/susceptibility/saveSusceptibility", array(
        "as"   => "drug.susceptibility",
        "uses" => "SusceptibilityController@store"
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
    // Check if able to manage lab configuration
    Route::group(array("before" => "checkPerms:manage_lab_configurations"), function()
    {
        Route::resource("facility", "FacilityController");
        Route::get("/facility/{id}/delete", array(
            "as"   => "facility.delete",
            "uses" => "FacilityController@delete"
        ));
        Route::any("/reportconfig/surveillance", array(
            "as"   => "reportconfig.surveillance",
            "uses" => "ReportController@surveillanceConfig"
        ));
        Route::any("/reportconfig/disease", array(
            "as"   => "reportconfig.disease",
            "uses" => "ReportController@disease"
        ));

        Route::resource("barcode", "BarcodeController");
        Route::any("/blisclient", array(
            "as"   => "blisclient.index",
            "uses" => "BlisClientController@index"
        ));
        Route::any("/blisclient/details", array(
            "as"   => "blisclient.details",
            "uses" => "BlisClientController@details"
        ));
        Route::any("/blisclient/properties", array(
            "as"   => "blisclient.properties",
            "uses" => "BlisClientController@properties"
        ));
    });
    
    //  Check if able to manage reports
    Route::group(array("before" => "checkPerms:view_reports"), function()
    {
        Route::get('specimentype', 'SpecimenTypeController@index');
        Route::get('testtype', 'TestTypeController@index');
        Route::any("/patientreport", array(
            "as"   => "reports.patient.index",
            "uses" => "ReportController@loadPatients"
        ));
        Route::any("/patientreport/{id}", array(
            "as" => "reports.patient.report", 
            "uses" => "ReportController@viewPatientReport"
        ));
        Route::any("/patientreport/{id}/{visit}/{testId?}", array(
            "as" => "reports.patient.report", 
            "uses" => "ReportController@viewPatientReport"
        ));
        Route::any("/dailylog", array(
            "as"   => "reports.daily.log",
            "uses" => "ReportController@dailyLog"
        ));
        Route::get('reports/dropdown', array(
            "as"    =>  "reports.dropdown",
            "uses"  =>  "ReportController@reportsDropdown"
        ));
        Route::any("/prevalence", array(
            "as"   => "reports.aggregate.prevalence",
            "uses" => "ReportController@prevalenceRates"
        ));
        Route::any("/surveillance", array(
            "as"   => "reports.aggregate.surveillance",
            "uses" => "ReportController@surveillance"
        ));
        Route::any("/counts", array(
            "as"   => "reports.aggregate.counts",
            "uses" => "ReportController@countReports"
        ));
        Route::any("/tat", array(
            "as"   => "reports.aggregate.tat",
            "uses" => "ReportController@turnaroundTime"
        ));
        Route::any("/infection", array(
            "as"   => "reports.aggregate.infection",
            "uses" => "ReportController@infectionReport"
        ));
        
        Route::any("/userstatistics", array(
            "as"   => "reports.aggregate.userStatistics",
            "uses" => "ReportController@userStatistics"
        ));

        Route::any("/moh706", array(
            "as"   => "reports.aggregate.moh706",
            "uses" => "ReportController@moh706"
        ));

        Route::any("/cd4", array(
            "as"   => "reports.aggregate.cd4",
            "uses" => "ReportController@cd4"
        ));
        
        Route::get("/qualitycontrol", array(
            "as"   => "reports.qualityControl",
            "uses" => "ReportController@qualityControl"
        ));
        Route::post("/qualitycontrol", array(
            "as"   => "reports.qualityControl",
            "uses" => "ReportController@qualityControlResults"
        ));
        Route::get("/inventory", array(
            "as"   => "reports.inventory",
            "uses" => "ReportController@stockLevel"
        ));
        Route::post("/inventory", array(
            "as"   => "reports.inventory",
            "uses" => "ReportController@stockLevel"
        ));

        Route::get("/stockcount", array(
            "as"   => "reports.stockcount",
            "uses" => "StockController@stockCountReport"
        ));
        Route::post("/stockcount", array(
            "as"   => "reports.stockcount",
            "uses" => "StockController@stockCountReport"
        ));

        Route::get("/inventoryusage", array(
            "as"   => "reports.inventoryusage",
            "uses" => "ReportController@usageLevel"
        ));
        Route::post("/inventoryusage", array(
            "as"   => "reports.inventoryusage",
            "uses" => "ReportController@usageLevel"
        ));
        
        Route::get('search/autocomplete', 'ReportController@autocomplete');

        Route::any("/rejection", array(
            "as"   => "reports.aggregate.rejection",
            "uses" => "ReportController@specimenRejectionChart"
        ));
        Route::any("/testaudit/{testid}", array(
            "as"   => "reports.audit.test",
            "uses" => "ReportController@viewTestAuditReport"
        ));
        Route::any("/critval", array(
            "as"   => "reports.aggregate.critval",
            "uses" => "ReportController@critical"
        ));
        Route::get("/adhocreport", array(
            "as"   => "reports.adhocreport.index",
            "uses" => "AdhocReportsController@index"
        ));
        Route::post("/adhocreport", array(
            "as"   => "reports.adhocreport.show",
            "uses" => "AdhocReportsController@store"
        ));
    });
    Route::group(array("before" => "checkPerms:manage_qc"), function()
    {
        Route::resource("lot", "LotController");
        Route::get('lot/{lotId}/delete', array(
            'uses' => 'LotController@delete'
        ));
        Route::any("controlresult/{id}/update",array(
            "as" => "controlresult.update",
            "uses" => "ControlResultsController@update"
            )
        );

        Route::get('controlresult/{controlTestId}/delete', array(
            'uses' => 'ControlResultsController@delete'
        ));
        Route::resource("control", "ControlController");
        Route::get("controlresults", array(
            "as"   => "control.resultsIndex",
            "uses" => "ControlController@resultsIndex"
        ));
        Route::get("controlresults/{controlId}/resultsEntry", array(
            "as" => "control.resultsEntry",
            "uses" => "ControlController@resultsEntry"
        ));
        Route::get("controlresults/{controlId}/resultsEdit", array(
            "as" => "control.resultsEdit",
            "uses" => "ControlController@resultsEdit"
        ));
    
        Route::get("controlresults/{controlId}/resultsList", array(
            "as" => "control.resultsList",
            "uses" => "ControlController@resultsList"
        ));
        Route::get('control/{controlId}/delete', array(
            'uses' => 'ControlController@destroy'
        ));
        Route::post('control/{controlId}/saveResults', array(
            "as" => "control.saveResults",
            'uses' => 'ControlController@saveResults'
        ));
        Route::post('control/{controlId}/resultsUpdate', array(
            "as" => "control.resultsUpdate",
            'uses' => 'ControlController@resultsUpdate'
        ));
    });
    
    Route::group(array("before" => "checkPerms:manage_inventory"), function()
    {
        //Commodities
        Route::resource('commodity', 'CommodityController');
        Route::get("/commodity/{id}/delete", array(
            "as"   => "commodity.delete",
            "uses" => "CommodityController@delete"
        ));
        //issues
        Route::resource('issue', 'IssueController');
        Route::get("/issue/{id}/delete", array(
            "as"   => "issue.delete",
            "uses" => "IssueController@delete"
        ));
        Route::get("/issue/{id}/dispatch", array(
            "as"   => "issue.dispatch",
            "uses" => "IssueController@dispatch"
        ));
        //Suppliers
        Route::resource('supplier', 'SupplierController');
        
        Route::get("/supplier/{id}/delete", array(
            "as"   => "supplier.delete",
            "uses" => "SupplierController@delete"
        ));
        /*
        *   Routes for items
        */
        Route::resource('item', 'ItemController');
        Route::get("/item/{id}/delete", array(
            "as"   => "item.delete",
            "uses" => "ItemController@delete"
        ));
        /*
        *   Routes for stocks
        */
        Route::resource('stock', 'StockController');
        Route::any("stock/{id}/log", array(
            "as"   => "stocks.log",
            "uses" => "StockController@index"
        ));
        Route::any("stock/{id}/create", array(
            "as"   => "stocks.create",
            "uses" => "StockController@create"
        ));
        Route::any("stock/{id}/usage/{req?}", array(
            "as"   => "stocks.usage",
            "uses" => "StockController@usage"
        ));
        Route::post("stock/saveusage", array(
            "as"   => "stock.saveUsage",
            "uses" => "StockController@stockUsage"
        ));
        Route::any("stock/{id}/show", array(
            "as"   => "stocks.show",
            "uses" => "StockController@show"
        ));
        Route::any("stock/{id}/lot", array(
            "as"   => "stocks.lot",
            "uses" => "StockController@lot"
        ));
        Route::any("lt/usage", array(
            "as"   => "lt.update",
            "uses" => "StockController@lotUsage"
        ));
    });

    Route::group(array("before" => "checkPerms:request_topup"), function()
    {
        /*
        *   Routes for requests for inventory items
        */
        Route::resource('request', 'TopupController');
        Route::get("/request/{id}/delete", array(
            "as"   => "request.delete",
            "uses" => "TopupController@delete"
        ));
        Route::get('topup/{id}/availableStock', array(
            "as"    =>  "issue.dropdown",
            "uses"  =>  "TopupController@availableStock"
        ));
    });
    Route::group(array("before" => "checkPerms:view_blood_bank"), function()
    {
        //Routes for blood-bank
        Route::resource('blood', 'BloodController');
    });
});
