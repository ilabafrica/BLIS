<?php
Route::get('/', [
    'uses' => 'WelcomeController@index'
]);

Route::get('/home', [
    'as' => 'user.home',
    'uses' => 'HomeController@index'
]);

Route::get('/auth/login', [
    'uses' => 'Auth\AuthController@getLogin'
]);

Route::post('/auth/login', [
    'uses' => 'Auth\AuthController@postLogin'
]);

Route::get('/auth/logout', [
    'uses' => 'Auth\AuthController@getLogout'
]);

Route::get('/password/email', [
    'uses' => 'Auth\PasswordController@getEmail'
]);

Route::post('/password/email', [
    'uses' => 'Auth\PasswordController@postEmail'
]);

Route::post('/password/reset', [
    'uses' => 'Auth\PasswordController@postReset'
]);

Route::resource('commodity', 'CommodityController');

Route::get('/commodity/{id}/delete', [
    'as' => 'commodity.delete',
    'before' => 'checkPerms:manage_inventory',
    'uses' => 'CommodityController@delete'
]);

Route::resource('control', 'ControlController');

Route::get('controlresults', [
    'as' => 'control.resultsIndex',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@resultsIndex'
]);

Route::get('controlresults/{controlId}/resultsEntry', [
    'as' => 'control.resultsEntry',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@resultsEntry'
]);

Route::get('controlresults/{controlId}/resultsEdit', [
    'as' => 'control.resultsEdit',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@resultsEdit'
]);

Route::get('controlresults/{controlId}/resultsList', [
    'as' => 'control.resultsList',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@resultsList'
]);

Route::get('control/{controlId}/delete', [
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@destroy'
]);

Route::post('control/{controlId}/saveResults', [
    'as' => 'control.saveResults',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@saveResults'
]);

Route::post('control/{controlId}/resultsUpdate', [
    'as' => 'control.resultsUpdate',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlController@resultsUpdate'
]);

Route::any('controlresult/{id}/update', [
    'as' => 'controlresult.update',
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlResultsController@update'
]);

Route::get('controlresult/{controlTestId}/delete', [
    'before' => 'checkPerms:manage_qc',
    'uses' => 'ControlResultsController@delete'
]);

Route::resource('drug', 'DrugController');

Route::get('/drug/{id}/delete', [
    'as' => 'drug.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'DrugController@delete'
]);

Route::resource('facility', 'FacilityController');

Route::get('/facility/{id}/delete', [
    'as' => 'facility.delete',
    'before' => 'checkPerms:manage_lab_configurations',
    'uses' => 'FacilityController@delete'
]);

Route::resource('instrument', 'InstrumentController');

Route::get('/instrument/{id}/delete', [
    'as' => 'instrument.delete',
    'uses' => 'InstrumentController@delete'
]);

Route::resource('issue', 'IssueController');

Route::get('/issue/{id}/delete', [
    'as' => 'issue.delete',
    'uses' => 'IssueController@delete'
]);

Route::get('/issue/{id}/dispatch', [
    'as' => 'issue.dispatch',
    'uses' => 'IssueController@dispatch'
]);

Route::resource('lot', 'LotController');

Route::get('lot/{lotId}/delete', [
    'before' => 'checkPerms:manage_qc',
    'uses' => 'LotController@delete'
]);

Route::resource('measure', 'MeasureController');

Route::get('/measure/{id}/delete', [
    'as' => 'measure.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'MeasureController@delete'
]);

Route::resource('metric', 'MetricController');

Route::get('/metric/{id}/delete', [
    'as' => 'metric.delete',
    'uses' => 'MetricController@delete'
]);

Route::resource('organism', 'OrganismController');

Route::get('/organism/{id}/delete', [
    'as' => 'organism.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'OrganismController@delete'
]);

Route::resource('patient', 'PatientController');

Route::get('/patient/{id}/delete', [
    'as' => 'patient.delete',
    'uses' => 'PatientController@delete'
]);

Route::post('/patient/search', [
    'as' => 'patient.search',
    'uses' => 'PatientController@search'
]);

Route::resource('permission', 'PermissionController');

Route::any('/rejection/{id}/delete', [
    'as' => 'rejection.delete',
    'uses' => 'ReasonController@delete'
]);

Route::resource('receipt', 'ReceiptController');

Route::get('/receipt/{id}/delete', [
    'as' => 'receipt.delete',
    'uses' => 'ReceiptController@delete'
]);

Route::any('/reportconfig/surveillance', [
    'as' => 'reportconfig.surveillance',
    'before' => 'checkPerms:manage_lab_configurations',
    'uses' => 'ReportController@surveillanceConfig'
]);

Route::any('/reportconfig/disease', [
    'as' => 'reportconfig.disease',
    'before' => 'checkPerms:manage_lab_configurations',
    'uses' => 'ReportController@disease'
]);

Route::any('/patientreport', [
    'as' => 'reports.patient.index',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@loadPatients'
]);

Route::any('/patientreport/{id}', [
    'as' => 'reports.patient.report',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@viewPatientReport'
]);

Route::any('/patientreport/{id}/{visit}/{testId?}', [
    'as' => 'reports.patient.report',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@viewPatientReport'
]);

Route::any('/dailylog', [
    'as' => 'reports.daily.log',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@dailyLog'
]);

Route::get('reports/dropdown', [
    'as' => 'reports.dropdown',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@reportsDropdown'
]);

Route::any('/prevalence', [
    'as' => 'reports.aggregate.prevalence',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@prevalenceRates'
]);

Route::any('/surveillance', [
    'as' => 'reports.aggregate.surveillance',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@surveillance'
]);

Route::any('/counts', [
    'as' => 'reports.aggregate.counts',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@countReports'
]);

Route::any('/tat', [
    'as' => 'reports.aggregate.tat',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@turnaroundTime'
]);

Route::any('/infection', [
    'as' => 'reports.aggregate.infection',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@infectionReport'
]);

Route::any('/userstatistics', [
    'as' => 'reports.aggregate.userStatistics',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@userStatistics'
]);

Route::get('/qualitycontrol', [
    'as' => 'reports.qualityControl',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@qualityControl'
]);

Route::post('/qualitycontrol', [
    'as' => 'reports.qualityControl',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@qualityControlResults'
]);

Route::get('/inventory', [
    'as' => 'reports.inventory',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@stockLevel'
]);

Route::post('/inventory', [
    'as' => 'reports.inventory',
    'before' => 'checkPerms:view_reports',
    'uses' => 'ReportController@stockLevel'
]);

Route::any('/patientreport/{id}/{visit}', [
    'as' => 'reports.patient.report',
    'uses' => 'ReportController@viewPatientReport'
]);

Route::get('role/assign', [
    'as' => 'role.assign',
    'before' => 'admin',
    'uses' => 'RoleController@assign'
]);

Route::post('role/assign', [
    'as' => 'role.assign',
    'before' => 'admin',
    'uses' => 'RoleController@saveUserRoleAssignment'
]);

Route::resource('role', 'RoleController');

Route::get('/role/{id}/delete', [
    'as' => 'role.delete',
    'before' => 'admin',
    'uses' => 'RoleController@delete'
]);

Route::get('authorize', [
    'as' => 'authorize',
    'uses' => 'RoleController@assign'
]);

Route::post('authorize', [
    'as' => 'authorize',
    'uses' => 'RoleController@saveUserRoleAssignment'
]);

Route::resource('specimenrejection', 'SpecimenRejectionController');

Route::any('/specimenrejection/{id}/delete', [
    'as' => 'specimenrejection.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'SpecimenRejectionController@delete'
]);

Route::resource('specimentype', 'SpecimenTypeController');

Route::get('/specimentype/{id}/delete', [
    'as' => 'specimentype.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'SpecimenTypeController@delete'
]);

Route::any('stock/{id}/log', [
    'as' => 'stocks.log',
    'uses' => 'StockController@index'
]);

Route::any('stock/{id}/create', [
    'as' => 'stocks.create',
    'uses' => 'StockController@create'
]);

Route::any('stock/{id}/usage', [
    'as' => 'stocks.usage',
    'uses' => 'StockController@usage'
]);

Route::post('stock/saveusage', [
    'as' => 'stock.saveUsage',
    'uses' => 'StockController@stockUsage'
]);

Route::any('stock/{id}/show', [
    'as' => 'stocks.show',
    'uses' => 'StockController@show'
]);

Route::any('stock/{id}/lot', [
    'as' => 'stocks.lot',
    'uses' => 'StockController@lot'
]);

Route::any('lot/usage', [
    'as' => 'lot.update',
    'uses' => 'StockController@lotUsage'
]);

Route::resource('supplier', 'SupplierController');

Route::get('/supplier/{id}/delete', [
    'as' => 'supplier.delete',
    'uses' => 'SupplierController@delete'
]);

Route::resource('testcategory', 'TestCategoryController');

Route::get('/testcategory/{id}/delete', [
    'as' => 'testcategory.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'TestCategoryController@delete'
]);

Route::any('/test', [
    'as' => 'test.index',
    'uses' => 'TestController@index'
]);

Route::post('/test/resultinterpretation', [
    'as' => 'test.resultinterpretation',
    'uses' => 'TestController@getResultInterpretation'
]);

Route::any('/test/{id}/receive', [
    'as' => 'test.receive',
    'before' => 'checkPerms:receive_external_test',
    'uses' => 'TestController@receive'
]);

Route::any('/test/create/{patient?}', [
    'as' => 'test.create',
    'before' => 'checkPerms:request_test',
    'uses' => 'TestController@create'
]);

Route::post('/test/savenewtest', [
    'as' => 'test.saveNewTest',
    'before' => 'checkPerms:request_test',
    'uses' => 'TestController@saveNewTest'
]);

Route::post('/test/acceptspecimen', [
    'as' => 'test.acceptSpecimen',
    'before' => 'checkPerms:accept_test_specimen',
    'uses' => 'TestController@accept'
]);

Route::get('/test/{id}/refer', [
    'as' => 'test.refer',
    'before' => 'checkPerms:refer_specimens',
    'uses' => 'TestController@showRefer'
]);

Route::post('/test/referaction', [
    'as' => 'test.referAction',
    'before' => 'checkPerms:refer_specimens',
    'uses' => 'TestController@referAction'
]);

Route::get('/test/{id}/reject', [
    'as' => 'test.reject',
    'before' => 'checkPerms:reject_test_specimen',
    'uses' => 'TestController@reject'
]);

Route::post('/test/rejectaction', [
    'as' => 'test.rejectAction',
    'before' => 'checkPerms:reject_test_specimen',
    'uses' => 'TestController@rejectAction'
]);

Route::post('/test/changespecimen', [
    'as' => 'test.changeSpecimenType',
    'before' => 'checkPerms:change_test_specimen',
    'uses' => 'TestController@changeSpecimenType'
]);

Route::post('/test/updatespecimentype', [
    'as' => 'test.updateSpecimenType',
    'before' => 'checkPerms:change_test_specimen',
    'uses' => 'TestController@updateSpecimenType'
]);

Route::post('/test/start', [
    'as' => 'test.start',
    'before' => 'checkPerms:start_test',
    'uses' => 'TestController@start'
]);

Route::get('/test/{test}/enterresults', [
    'as' => 'test.enterResults',
    'before' => 'checkPerms:enter_test_results',
    'uses' => 'TestController@enterResults'
]);

Route::get('/test/{test}/edit', [
    'as' => 'test.edit',
    'before' => 'checkPerms:edit_test_results',
    'uses' => 'TestController@edit'
]);

Route::post('/test/{test}/saveresults', [
    'as' => 'test.saveResults',
    'before' => 'checkPerms:edit_test_results',
    'uses' => 'TestController@saveResults'
]);

Route::get('/test/{test}/viewdetails', [
    'as' => 'test.viewDetails',
    'uses' => 'TestController@viewDetails'
]);

Route::any('/test/{test}/verify', [
    'as' => 'test.verify',
    'before' => 'checkPerms:verify_test_results',
    'uses' => 'TestController@verify'
]);

Route::resource('testtype', 'TestTypeController');

Route::get('/testtype/{id}/delete', [
    'as' => 'testtype.delete',
    'before' => 'checkPerms:manage_test_catalog',
    'uses' => 'TestTypeController@delete'
]);

Route::resource('topup', 'TopUpController');

Route::get('/topup/{id}/delete', [
    'as' => 'topup.delete',
    'before' => 'checkPerms:request_topup',
    'uses' => 'TopUpController@delete'
]);

Route::get('topup/{id}/availableStock', [
    'as' => 'issue.dropdown',
    'before' => 'checkPerms:request_topup',
    'uses' => 'TopUpController@availableStock'
]);

Route::resource('user', 'UserController');

Route::get('/user/{id}/delete', [
    'as' => 'user.delete',
    'before' => 'checkPerms:manage_users',
    'uses' => 'UserController@delete'
]);

Route::any('/logout', [
    'as' => 'user.logout',
    'uses' => 'UserController@logoutAction'
]);

Route::any('/user/{id}/updateown', [
    'as' => 'user.updateOwnPassword',
    'uses' => 'UserController@updateOwnPassword'
]);

