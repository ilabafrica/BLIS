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
		$testStatus = TestStatus::all();
		$searchString = Input::get('search');
		$testStatusId = Input::get('testStatusId');
		$dateFrom = Input::get('dateFrom');
		$dateTo = Input::get('dateTo');
		if($searchString||$testStatusId||$dateFrom||$dateTo){
			$tests = Test::with('visit', 'testType', 'specimen', 'testStatus', 'testStatus.testPhase')->where(function($q) use ($searchString){
				$q->whereHas('visit', function($q) use ($searchString){
					$q->whereHas('patient', function($q)  use ($searchString){
						$q->where('name', 'like', '%' . $searchString . '%')//Search by patient name
						  ->orWhere('patient_number', 'like', '%' . $searchString . '%');//Search by patient number
					});
				})->orWhereHas('testType', function($q) use ($searchString){
				    $q->where('name', 'like', '%' . $searchString . '%');//Search by test type
				})->orWhereHas('specimen', function($q) use ($searchString){
				    $q->where('id', 'like', '%' . $searchString . '%');//Search by specimen number
				})->orWhereHas('visit',  function($q) use ($searchString){
					$q->where('id', 'like', '%' . $searchString . '%');//Search by visit number
				});
			});
			if ($testStatusId) {
				$tests = $tests->where(function($q) use ($testStatusId){
					$q->whereHas('testStatus', function($q) use ($testStatusId){
					    $q->where('id','=', $testStatusId);//Filter by test status
					});
				});
			}

			if ($dateFrom||$dateTo) {
				$tests = $tests->where(function($q) use ($dateFrom, $dateTo){
					$q->whereHas('specimen', function($q) use ($dateFrom, $dateTo){//Filter by date created
						$q = $q->where('time_created', '>=', $dateFrom);
						(empty($dateTo)) ? $q : $q->where('time_created', '<=', $dateTo);
					});
				});
			}
			$tests = $tests->orderBy('time_created', 'DESC')->paginate(Config::get('kblis.page-items'));
			if (count($tests) == 0) {
			 	Session::flash('message', 'Your search <b>'.$searchString.'</b>, did not match any test record!');
			}
		}
		else{
		// List all the active tests
			$tests = Test::paginate(Config::get('kblis.page-items'));
		}
		// Load the view and pass the tests
		return View::make('test.index')->with('tests', $tests)
									   ->with('testStatus', $testStatus)
									   ->with('search', $searchString)
									   ->with('testStatusId', $testStatusId)
									   ->with('dateFrom', $dateFrom)
									   ->with('dateTo', $dateTo);
	}

	/**
	 * Test Search
	 *
	 * @return Response
	 */
	public function testSearch()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$measures = Measure::all();
		$specimentypes = SpecimenType::all();
		$labsections = TestCategory::all();
		//Create TestType
		return View::make('test.create')
					->with('labsections', $labsections)
					->with('measures', $measures)
					->with('specimentypes', $specimentypes);
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

		// foreach($test->testType->measures as $measure){

		// }
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