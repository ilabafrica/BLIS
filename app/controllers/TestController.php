<?php

use Illuminate\Database\QueryException;

/**
 * Contains test resources  
 * 
 */
class TestController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active tests
			$tests = Test::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the tests
		return View::make('test.index')->with('testSet', $tests);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($patient_id)
	{
		$specimenTypes = SpecimenType::all();
		$patient = Patient::find($patient_id);
		$specimenTests = array();

		foreach ($specimenTypes as $specimenType) {
			foreach ($specimenType->testTypes as $testType) {
				$specimenTests[] = [$specimenType->id, $specimenType->name, $testType->id, $testType->name];
			}
		}

		//Load Test Create View
		return View::make('test.create')
					->with('specimentypes', $specimenTypes)
					->with('specimentests', $specimenTests)
					->with('patient', $patient);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function saveNewTest()
	{
		//Create New Test
		$rules = array(
			'specimentype' => 'required',
			'tests'       => 'required',
			'physician' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
/*
| - Create a visit if patient has none
| - Fields required: visit_id, test_type_id, specimen_id, test_status_id, created_by, tested_by, requested_by, time_created
|
*/
			// store
			// $test = new Test;
			// $test->patient_number = Input::get('patient_number');
			// $test->name = Input::get('name');
			// $test->gender = Input::get('gender');

			// try{
			// 	$patient->save();
			// 	return Redirect::to('patient')->with('message', 'Successfully created patient!');
			// }catch(QueryException $e){
			// 	Log::error($e);
			// }
			
			// redirect
		}
	}

	/**
	 * Display Rejection page 
	 *
	 * @param
	 * @return
	 */
	public function reject($specimenID)
	{
		
		$rejectionReason = RejectionReason::all();
		return View::make('test.reject')->with('specimenId', $specimenID)
								->with('rejectionReason', $rejectionReason);
	}

	/**
	 * Executes Rejection
	 *
	 * @param
	 * @return
	 */
	public function rejectAction($specimenID)
	{
		$specimen = Specimen::find($specimenID);
		$specimen->rejection_reason_id = Input::get('rejectionReason');
		$specimen->specimen_status_id = 2;//Rejected
		$specimen->save();
		// redirect
		Session::flash('message', 'Specimen was successfully rejected!');
		return Redirect::to('test');
	}

	/**
	 * Starts Test
	 *
	 * @param
	 * @return
	 */
	public function start($testID)
	{
		$test = Test::find($testID);
		$test->test_status_id = 2;//Started
		$test->save();
		// redirect
		Session::flash('message', 'Test started!');
		return Redirect::to('test');
	}

	/**
	 * Display Result Entry page
	 *
	 * @param
	 * @return
	 */
	public function enterResults($testID)
	{
		$test = Test::find($testID);
		return View::make('test.enterResults')->with('test', $test);
	}

	/**
	 * Saves Test Results
	 *
	 * @param
	 * @return
	 */
	public function saveResults($testID)
	{
		$test = Test::find($testID);
		$test->test_status_id = 3;//Completed
		$test->interpretation = Input::get('interpretation');
		$test->tested_by = Auth::user()->id;
		$test->save();
		
		foreach ($test->testType->measures as $measure) {
			$testResult = TestResult::firstOrCreate(array('test_id' => $testID, 'measure_id' => $measure->id));
			$testResult->result = Input::get('m_'.$measure->id);
			$testResult->save();
		}

		// redirect
		Session::flash('message', 'Results successfully saved!');
		return Redirect::route('test.index');
	}


	/**
	 * Display Edit page
	 *
	 * @param
	 * @return
	 */
	public function edit($testID)
	{
		$test = Test::find($testID);

		return View::make('test.edit')->with('test', $test);
	}

	/**
	 * Display Test Details
	 *
	 * @param
	 * @return
	 */
	public function viewDetails($testID)
	{
		return View::make('test.viewDetails')->with('test', Test::find($testID));
	}

	/**
	 * Display Verification page
	 *
	 * @param
	 * @return
	 */
	public function verify()
	{
		return View::make('test.verify');//->with('', $);
	}
}