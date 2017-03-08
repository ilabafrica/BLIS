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
		$reportid=Input::get('report');
		$testType=Input::get('testType');
		$testColumns=Input::get('testColumns');
		$statusColumns=Input::get('statusColumns');
		$lowerage=Input::get('lowerage');
		$upperage=Input::get('upperage');
		$gender=Input::get('gender');
		$from = Input::get('from');
		$to = Input::get('to');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$error = '';
		$visitId = Input::get('visit_id');
		//check which report is submitted
		if($reportid==2){
			return	$this->testReport($from,$to,$testType,$date,$testColumns,$lowerage,$upperage,$gender,$statusColumns);
		}else if($reportid==3){
			return $this->specimenReport($from,$to,$testType,$date,$testColumns,$lowerage,$upperage,$gender);
		}
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
	*
	*/
	public function testReport($from,$to,$testType,$date,$testColumns,$lowerage,$upperage,$selected_gender,$statusColumns){
			$reportsController=new ReportController;
			$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
			$testCategories = TestCategory::all();
			if($testType!=-1){
				$testTypes = TestType::where('id',$testType)->get();
			}else{
				$testTypes = TestType::all();
			}
			
			$ageRanges = array($lowerage.'-'.$upperage);	//	Age ranges - will definitely change in configurations
			
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perTestType = array();	//	array for counts data per testype
			$perStatus=array();
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			foreach ($testTypes as $testType) {
				
				$countAll = $reportsController->getGroupedTestCounts($testType, null, null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $reportsController->getGroupedTestCounts($testType, [Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $reportsController->getGroupedTestCounts($testType, [Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perTestType[$testType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $reportsController->getGroupedTestCounts($testType, [Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $reportsController->getGroupedTestCounts($testType, [Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$testType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
				$count=0;

				//Filter by age range
				$ageRange = explode('-', $ageRanges[0]);
				$ageStart = $ageRange[0];
				$ageEnd = $ageRange[1];
				
				$now = new DateTime('now');
				$finishDate = $now->sub(new DateInterval('P'.$ageStart.'Y'))->format('Y-m-d');
				$startDate = $now->sub(new DateInterval('P'.$ageEnd.'Y'))->format('Y-m-d');

				foreach($statusColumns as $status){
				
				

					$tests = Test::
					join('visits', 'tests.visit_id', '=', 'visits.id')
					->join('patients', 'visits.patient_id', '=', 'patients.id')
					->where('test_status_id', $status['id'])
					->where('test_type_id',$testType->id)
					->where(function($q) use ($from, $to)
						{
							if($from)$q->where('time_created', '>=', $from);

							if($to){
								$to = $to . ' 23:59:59';
								$q->where('time_created', '<=', $to);
							}
						})->whereBetween('dob',[$startDate, $finishDate])->get();
					/*if($ageRange){
						$tests->whereBetween('dob',[$startDate, $finishDate]);
					}*/
					
					//$tests->get();
					$a=array(
						'name'=>$status['name'],
						'count'=>count($tests)
					);
					$perStatus["$testType->id"][$count]=$a;
					$count++;
				}
			}
			// print_r($perStatus); exit;
			return View::make('adhocreport.testsreport')
						->with('testCategories', $testCategories)
						->with('ageRanges', $ageRanges)
						->with('gender', $selected_gender)
						->with('testType', $testTypes)
						->with('perAgeRange', $perAgeRange)
						->with('testColumns',$testColumns)
						->with('statusColumns',$statusColumns)
						->with('genderCount',count($selected_gender))
						->with('perTestType', $perTestType)
						->with('perStatus', $perStatus)
						//->with('accredited', $accredited)
						->withInput(Input::all());
		
	}

	public function specimenReport($from,$to,$specimenType,$date,$testColumns,$lowerage,$upperage,$selected_gender){
		 	$specimentype=new SpecimenType;
			$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
			$testCategories = TestCategory::all();
			$specimenTypes = SpecimenType::find($specimenType);
			$ageRanges = array($lowerage.'-'.$upperage);	//	Age ranges - will definitely change in configurations
			
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perTestType = array();	//	array for counts data per testype
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			foreach ($specimenTypes as $specimenType) {
				$countAll = $specimenTypes->groupedSpecimenCount([Patient::MALE, Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $specimenTypes->groupedSpecimenCount([Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $specimenTypes->groupedSpecimenCount([Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perSpecimenType[$specimenTypes->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $specimenTypes->groupedSpecimenCount([Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $specimenTypes->groupedSpecimenCount([Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$specimenTypes->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
			}
			return View::make('adhocreport.specimenreport')
						->with('testCategories', $testCategories)
						->with('ageRanges', $ageRanges)
						->with('gender', $selected_gender)
						->with('specimenType', $specimenTypes)
						->with('perAgeRange', $perAgeRange)
						->with('testColumns',$testColumns)
						->with('genderCount',count($selected_gender))
						->with('perSpecimenType', $perSpecimenType)
						//->with('accredited', $accredited)
						->withInput(Input::all());
	}

}
