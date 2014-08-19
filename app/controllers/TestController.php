<?php

use Illuminate\Support\MessageBag;
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
		return View::make('test.index')->with('tests', $tests);
	}


	/**
	 * Display Rejection page
	 *
	 * @param
	 * @return
	 */
	public function reject($specimenId)
	{
		
		$rejectionReason = RejectionReason::all();
		return View::make('test.reject')->with('specimenId', $specimenId)
								->with('rejectionReason', $rejectionReason);
	}

	/**
	 * Executes Rejection
	 *
	 * @param
	 * @return
	 */
	public function rejectAction($specimenId)
	{
		$specimen = Specimen::find($specimenId);
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
	public function start($testId)
	{
		$test = Test::find($testId);
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
	public function enterResults($testId)
	{
		$testTypeId = Test::find($testId)->test_type_id;
		$testType = TestType::find($testTypeId);
		return View::make('test.enterResults')->with('testType', $testType->name)
											->with('testId', $testId);
	}

	/**
	 * Saves Test Results
	 *
	 * @param
	 * @return
	 */
	public function saveResults($testId)
	{
		$test = Test::find($testId);
		$test->test_status_id = 3;//Completed
		$test->interpretation = Input::get('interpretation');
		$test->save();
		$testType = TestType::find($test->test_type_id);
		
		// $testResult = TestResult::find($testId);
		// $testResult = new TestResult;
	 	// $testResult->test_id = $testId;
	 	// $testResult->measure_id = $testType->measures()->where('test_type_id', $testType->id)->measure_id;
	 	// $testResult->result = Input::get('result');
		// $testResult->save();

		// redirect
		Session::flash('message', 'Results successfully saved!');
		return Redirect::to('test');
	}


	/**
	 * Display Edit page
	 *
	 * @param
	 * @return
	 */
	public function edit()
	{
		return View::make('test.edit');//->with('', $);
	}

	/**
	 * Display Test Details
	 *
	 * @param
	 * @return
	 */
	public function viewDetails()
	{
		return View::make('test.viewDetails');//->with('', $);
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