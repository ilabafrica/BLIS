<?php

class AdhocReportsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('adhocreport.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store( $visit = null, $testId = null)
	{
		$id=Input::get('patient');
		$from = Input::get('from');
		$to = Input::get('to');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$error = '';
		$visitId = Input::get('visit_id');
		//	Check checkbox if checked and assign the 'checked' value
		if (Input::get('tests') === '1') {
		    $pending='checked';
		}
		//	Query to get tests of a particular patient
		if (($visit || $visitId) && $id && $testId){
			$tests = Test::where('id', '=', $testId);
		}
		else if(($visit || $visitId) && $id){
			$tests = Test::where('visit_id', '=', $visit?$visit:$visitId);
		}
		else{
			$tests = Test::join('visits', 'visits.id', '=', 'tests.visit_id')
							->where('patient_id', '=', $id);
		}
		//	Begin filters - include/exclude pending tests
		if($pending){
			$tests=$tests->where('tests.test_status_id', '!=', Test::NOT_RECEIVED);
		}
		else{
			$tests = $tests->whereIn('tests.test_status_id', [Test::COMPLETED, Test::VERIFIED]);
		}
		//	Date filters
		if($from||$to){

			if(!$to) $to = $date;

			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
					$error = trans('messages.check-date-range');
			}
			else
			{
				$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
				$tests=$tests->whereBetween('time_created', array($from, $toPlusOne->format('Y-m-d H:i:s')));
			}
		}
		//	Get tests collection
		$tests = $tests->get(array('tests.*'));
		//	Get patient details
		$patient = Patient::find($id);
		//	Check if tests are accredited
		$reportsController= new ReportController;
		$accredited = $reportsController->accredited($tests);
		$verified = array();
		foreach ($tests as $test) {
			if($test->isVerified())
				array_push($verified, $test->id);
			else
				continue;
		}
		
			

		if(Input::has('word')){
			$date = date("Ymdhi");
			$fileName = "blispatient_".$id."_".$date.".doc";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$fileName
			);
			$content = View::make('reports.patient.export')
							->with('patient', $patient)
							->with('tests', $tests)
							->with('from', $from)
							->with('to', $to)
							->with('visit', $visit)
							->with('accredited', $accredited);
	    	return Response::make($content,200, $headers);
		}else{
		return View::make('adhocreport.show')
						->with('patient', $patient)
						->with('tests', $tests)
						->with('pending', $pending)
						->with('error', $error)
						->with('visit', $visit)
						->with('accredited', $accredited)
						->with('verified', $verified)
						->with('resultsColumns', Input::get('results'))
						->with('specimenColumns', Input::get('specimen'))
						->withInput(Input::all());
		
		}
		
		
		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
