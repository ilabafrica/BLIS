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
		$testTypes = TestType::all();
		$patient = Patient::find($patient_id);

		//Load Test Create View
		return View::make('test.create')
					->with('testtypes', $testTypes)
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
			'testtypes' => 'required',
			'physician' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {

			$visitType = ['In-patient', 'Out-patient'];
			$patient = Patient::find(Input::get('patient_id'));

			/*
			| - Create a visit
			| - Fields required: visit_type, patient_id
			*/
			$visit = new Visit;
			$visit->patient_id = Input::get('patient_id');
			$visit->visit_type = $visitType[Input::get('visit_type')];
			$visit->save();

			/*
			| - Create tests requested
			| - Fields required: visit_id, test_type_id, specimen_id, test_status_id, created_by, requested_by
			*/
			$testTypes = Input::get('testtypes');
			if(is_array($testTypes)){
				foreach ($testTypes as $key => $value) {
					// Create Specimen - specimen_type_id, created_by, referred_from, referred_to
					$specimen = new Specimen;
					$specimen->specimen_type_id = TestType::find((int)$value)->specimenTypes->lists('id')[0];
					$specimen->created_by = Auth::user()->id;
					$specimen->referred_to = 0; //No one
					$specimen->referred_from = 0; //No one
					$specimen->save();

					$test = new Test;
					$test->visit_id = $visit->id;
					$test->test_type_id = (int)$value;
					$test->specimen_id = $specimen->id;
					$test->test_status_id = 1; //Pending
					$test->created_by = Auth::user()->id;
					$test->requested_by = Input::get('physician');
					$test->save();
				}
			}

			return Redirect::to('patient')->with('message', 'messages.success-creating-test');
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
		return View::make('test.verify');
	}

	/**
	 * Get test status by test ID
	 *
	 * @param
	 * @return
	 */
	public function getTestStatusById($testID)
	{
		$test = Test::find($testID);
		return trans('messages.'.$test->testStatus->name);
	}
}