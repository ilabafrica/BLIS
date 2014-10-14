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
			$tests = Test::with('visit', 'visit.patient', 'testType', 'specimen', 'testStatus', 'testStatus.testPhase')->where(function($q) use ($searchString){
				$q->whereHas('visit', function($q) use ($searchString){
					$q->whereHas('patient', function($q)  use ($searchString){
						(is_numeric($searchString)) ? $q->where('patient_number', 'like', '%' . $searchString . '%') : $q->where('name', 'like', '%' . $searchString . '%');
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
			$tests = Test::orderBy('time_created', 'desc')->paginate(Config::get('kblis.page-items'));
		}
		// Load the view and pass the tests
		return View::make('test.index')->with('testSet', $tests)
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
	 * Display a form for creating a new Test.
	 *
	 * @return Response
	 */
	public function create($patientID = 0)
	{
		if ($patientID == 0) {
			$patientID = Input::get('patient_id');
		}
		$testTypes = TestType::all();
		$patient = Patient::find($patientID);

		//Load Test Create View
		return View::make('test.create')
					->with('testtypes', $testTypes)
					->with('patient', $patient);
	}

	/**
	 * Save a new Test.
	 *
	 * @return Response
	 */
	public function saveNewTest()
	{
		//Create New Test
		$rules = array(
			'physician' => 'required',
			'testtypes' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::route('test.create', array(Input::get('patient_id')))->withInput()->withErrors($validator);
		} else {

			$visitType = ['In-patient', 'Out-patient'];

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
					// Create Specimen - specimen_type_id, accepted_by, referred_from, referred_to
					$specimen = new Specimen;
					$specimen->specimen_type_id = TestType::find((int)$value)->specimenTypes->lists('id')[0];
					$specimen->accepted_by = Auth::user()->id;
					$specimen->referred_to = 0; //No one
					$specimen->referred_from = 0; //No one
					$specimen->save();

					$test = new Test;
					$test->visit_id = $visit->id;
					$test->test_type_id = (int)$value;
					$test->specimen_id = $specimen->id;
					$test->test_status_id = Test::PENDING;
					$test->created_by = Auth::user()->id;
					$test->requested_by = Input::get('physician');
					$test->save();
				}
			}

			return Redirect::to('test')->with('message', 'messages.success-creating-test');
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
		$specimen = Specimen::find($specimenID);
		$rejectionReason = RejectionReason::all();
		return View::make('test.reject')->with('specimen', $specimen)
						->with('rejectionReason', $rejectionReason);
	}

	/**
	 * Executes Rejection
	 *
	 * @param
	 * @return
	 */
	public function rejectAction()
	{
		$specimenID = Input::get('specimen_id');
		$specimen = Specimen::find($specimenID);
		$specimen->rejection_reason_id = Input::get('rejectionReason');
		$specimen->specimen_status_id = Specimen::REJECTED;
		$specimen->time_rejected = date('Y-m-d H:i:s');
		$specimen->reject_explained_to = Input::get('reject_explained_to');
		$specimen->save();
		// redirect
		Session::flash('message', 'Specimen was rejected!');
		return Redirect::to('test');
	}

	/**
	 * Accept a Test's Specimen
	 *
	 * @param
	 * @return
	 */
	public function accept()
	{
		$specimen = Specimen::find(Input::get('id'));
		$specimen->specimen_status_id = Specimen::ACCEPTED;
		$specimen->time_accepted = date('Y-m-d H:i:s');
		$specimen->save();

		return $specimen->specimen_status_id;
	}

	/**
	 * Display Change specimenType form fragment to be loaded in a modal via AJAX
	 *
	 * @param
	 * @return
	 */
	public function changeSpecimenType()
	{
		$test = Test::find(Input::get('id'));
		return View::make('test.changeSpecimenType')->with('test', $test);
	}

	/**
	 * Update a Test's SpecimenType
	 *
	 * @param
	 * @return
	 */
	public function updateSpecimenType()
	{
		$specimen = Specimen::find(Input::get('specimen_id'));
		$specimen->specimen_type_id = Input::get('specimen_type');
		$specimen->save();

		return Redirect::to('test/'.$specimen->test->id.'/viewdetails');
	}

/**
	 * Starts Test
	 *
	 * @param
	 * @return
	 */
	public function start()
	{
		$test = Test::find(Input::get('id'));
		$test->test_status_id = Test::STARTED;
		$test->time_started = date('Y-m-d H:i:s');
		$test->save();

		return $test->test_status_id;
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
		$test->test_status_id = Test::COMPLETED;
		$test->interpretation = Input::get('interpretation');
		$test->tested_by = Auth::user()->id;
		$test->time_completed = date('Y-m-d H:i:s');
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

}