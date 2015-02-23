<?php

class ReportController extends \BaseController {
	//	Begin patient report functions
	/**
	 * Display a listing of the resource.
	 * Called loadPatients because the same controller shall be used for all other reports
	 * @return Response
	 */
	public function loadPatients()
	{
		$search = Input::get('search');

		$patients = Patient::search($search)->orderBy('id','DESC')->paginate(Config::get('kblis.page-items'));

		if (count($patients) == 0) {
		 	Session::flash('message', trans('messages.no-match'));
		}

		// Load the view and pass the patients
		return View::make('reports.patient.index')->with('patients', $patients)->withInput(Input::all());
	}

	/**
	 * Display data after applying the filters on the report uses patient ID
	 *
	 * @return Response
	 */
	public function viewPatientReport($id, $visit = null){
		$from = Input::get('start');
		$to = Input::get('end');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$error = '';
		//	Check checkbox if checked and assign the 'checked' value
		if (Input::get('tests') === '1') {
		    $pending='checked';
		}
		//	Query to get tests of a particular patient
		if($visit && $id){
			$tests = Test::where('visit_id', '=', $visit);
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
							->with('visit', $visit);
	    	return Response::make($content,200, $headers);
		}
		else{
			return View::make('reports.patient.report')
						->with('patient', $patient)
						->with('tests', $tests)
						->with('pending', $pending)
						->with('error', $error)
						->with('visit', $visit)
						->withInput(Input::all());
		}
	}
	//	End patient report functions

	/**
	*	Function to return test types of a particular test category to fill test types dropdown
	*/
	public function reportsDropdown(){
        $input = Input::get('option');
        $testCategory = TestCategory::find($input);
        $testTypes = $testCategory->testTypes();
        return Response::make($testTypes->get(['id','name']));
    }

	//	Begin Daily Log-Patient report functions
	/**
	 * Display a view of the daily patient records.
	 *
	 */
	public function dailyLog()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		$pendingOrAll = Input::get('pending_or_all');
		$error = '';
		//	Check radiobutton for pending/all tests is checked and assign the 'true' value
		if (Input::get('tests') === '1') {
		    $pending='true';
		}
		$date = date('Y-m-d');
		if(!$to){
			$to=$date;
		}
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$records = Input::get('records');
		$testCategory = Input::get('section_id');
		$testType = Input::get('test_type');
		$labSections = TestCategory::lists('name', 'id');
		if($testCategory)
			$testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
		else
			$testTypes = array(""=>"");
		
		if($records=='patients'){
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else{
					$visits = Visit::whereBetween('created_at', array($from, $toPlusOne))->get();
				}
				if (count($visits) == 0) {
				 	Session::flash('message', trans('messages.no-match'));
				}
			}
			else{

				$visits = Visit::where('created_at', 'LIKE', $date.'%')->orderBy('patient_id')->get();
			}
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_visits_log_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportPatientLog')
								->with('visits', $visits)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else{
				return View::make('reports.daily.patient')
								->with('visits', $visits)
								->with('error', $error)
								->withInput(Input::all());
			}
		}
		//Begin specimen rejections
		else if($records=='rejections')
		{
			$specimens = Specimen::where('specimen_status_id', '=', Specimen::REJECTED);
			/*Filter by test category*/
			if($testCategory&&!$testType){
				$specimens = $specimens->join('tests', 'specimens.id', '=', 'tests.specimen_id')
									   ->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
									   ->where('test_types.test_category_id', '=', $testCategory);
			}
			/*Filter by test type*/
			if($testCategory&&$testType){
				$specimens = $specimens->join('tests', 'specimens.id', '=', 'tests.specimen_id')
				   					   ->where('tests.test_type_id', '=', $testType);
			}

			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else
				{
					$specimens = $specimens->whereBetween('time_rejected', 
						array($from, $toPlusOne))->get(array('specimens.*'));
				}
			}
			else
			{
				$specimens = $specimens->where('time_rejected', 'LIKE', $date.'%')->orderBy('id')
										->get(array('specimens.*'));
			}
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_rejected_specimen_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportSpecimenLog')
								->with('specimens', $specimens)
								->with('testCategory', $testCategory)
								->with('testType', $testType)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else
			{
				return View::make('reports.daily.specimen')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('specimens', $specimens)
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('error', $error)
							->withInput(Input::all());
			}
		}
		//Begin test records
		else
		{
			$tests = Test::whereNotIn('test_status_id', [Test::NOT_RECEIVED]);
			
			/*Filter by test category*/
			if($testCategory&&!$testType){
				$tests = $tests->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
							   ->where('test_types.test_category_id', '=', $testCategory);
			}
			/*Filter by test type*/
			if($testType){
				$tests = $tests->where('test_type_id', '=', $testType);
			}
			/*Filter by all tests*/
			if($pendingOrAll=='pending'){
				$tests = $tests->whereIn('test_status_id', [Test::PENDING, Test::STARTED]);
			}
			else if($pendingOrAll=='all'){
				$tests = $tests->whereIn('test_status_id', 
					[Test::PENDING, Test::STARTED, Test::COMPLETED, Test::VERIFIED]);
			}
			//For Complete tests and the default.
			else{
				$tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
			}
			/*Get collection of tests*/
			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						$error = trans('messages.check-date-range');
				}
				else
				{
					$tests = $tests->whereBetween('time_created', array($from, $toPlusOne))->get(array('tests.*'));
				}
			}
			else
			{
				$tests = $tests->where('time_created', 'LIKE', $date.'%')->get(array('tests.*'));
			}
				
			if(Input::has('word')){
				$date = date("Ymdhi");
				$fileName = "daily_test_records_".$date.".doc";
				$headers = array(
				    "Content-type"=>"text/html",
				    "Content-Disposition"=>"attachment;Filename=".$fileName
				);
				$content = View::make('reports.daily.exportTestLog')
								->with('tests', $tests)
								->with('testCategory', $testCategory)
								->with('testType', $testType)
								->with('pendingOrAll', $pendingOrAll)
								->withInput(Input::all());
		    	return Response::make($content,200, $headers);
			}
			else
			{
				return View::make('reports.daily.test')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('tests', $tests)
							->with('counts', $tests->count())
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('pendingOrAll', $pendingOrAll)
							->with('error', $error)
							->withInput(Input::all());
			}
		}
	}
	//	End Daily Log-Patient report functions

	/*	Begin Aggregate reports functions	*/
	//	Begin prevalence rates reports functions
	/**
	 * Display a both chart and table on load.
	 *
	 * @return Response
	 */
	public function prevalenceRates()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		$today = date('Y-m-d');
		$year = date('Y');
		$testTypeID = Input::get('test_type');

		//	Apply filters if any
		if(Input::has('filter')){

			if(!$to) $to=$today;

			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$months = json_decode(self::getMonths($from, $to));
			$data = TestType::getPrevalenceCounts($from, $to, $testTypeID);
			$chart = self::getPrevalenceRatesChart($testTypeID);
		}
		else
		{
			// Get all tests for the current year
			$test = Test::where('time_created', 'LIKE', date('Y').'%');
			$periodStart = $test->min('time_created'); //Get the minimum date
			$periodEnd = $test->max('time_created'); //Get the maximum date
			$data = TestType::getPrevalenceCounts($periodStart, $periodEnd);
			$chart = self::getPrevalenceRatesChart();
		}

		return View::make('reports.prevalence.index')
						->with('data', $data)
						->with('chart', $chart)
						->withInput(Input::all());
	}

	/**
	* Get months: return months for time_created column when filter dates are set
	*/	
	public static function getMonths($from, $to){
		$today = "'".date("Y-m-d")."'";
		$year = date('Y');
		$tests = Test::select('time_created')->distinct();

		if(strtotime($from)===strtotime($today)){
			$tests = $tests->where('time_created', 'LIKE', $year.'%');
		}
		else
		{
			$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
			$tests = $tests->whereBetween('time_created', array($from, $toPlusOne));
		}

		$allDates = $tests->lists('time_created');
		asort($allDates);
		$yearMonth = function($value){return strtotime(substr($value, 0, 7));};
		$allDates = array_map($yearMonth, $allDates);
		$allMonths = array_unique($allDates);
		$dates = array();

		foreach ($allMonths as $date) {
			$dateInfo = getdate($date);
			$dates[] = array('months' => $dateInfo['mon'], 'label' => substr($dateInfo['month'], 0, 3),
				'annum' => $dateInfo['year']);
		}

		return json_encode($dates);
	}
	/**
	 * Display prevalence rates chart
	 *
	 * @return Response
	 */
	public static function getPrevalenceRatesChart($testTypeID = 0){
		$from = Input::get('start');
		$to = Input::get('end');
		$months = json_decode(self::getMonths($from, $to));
		$testTypes = new Illuminate\Database\Eloquent\Collection();

		if($testTypeID == 0){
			
			$testTypes = TestType::supportPrevalenceCounts();
		}else{
			$testTypes->add(TestType::find($testTypeID));
		}

		$options = '{
		    "chart": {
		        "type": "spline"
		    },
		    "title": {
		        "text":"'.trans('messages.prevalence-rates').'"
		    },
		    "subtitle": {
		        "text":'; 
		        if($from==$to)
		        	$options.='"'.trans('messages.for-the-year').' '.date('Y').'"';
		        else
		        	$options.='"'.trans('messages.from').' '.$from.' '.trans('messages.to').' '.$to.'"';
		    $options.='},
		    "credits": {
		        "enabled": false
		    },
		    "navigation": {
		        "buttonOptions": {
		            "align": "right"
		        }
		    },
		    "series": [';
		    	$counts = count($testTypes);

			    	foreach ($testTypes as $testType) {
		        		$options.= '{
		        			"name": "'.$testType->name.'","data": [';
		        				$counter = count($months);
		            			foreach ($months as $month) {
		            			$data = $testType->getPrevalenceCount($month->annum, $month->months);
		            				if($data->isEmpty()){
		            					$options.= '0.00';
		            					if($counter==1)
			            					$options.='';
			            				else
			            					$options.=',';
		            				}
		            				else{
		            					foreach ($data as $datum) {
				            				$options.= $datum->rate;

				            				if($counter==1)
				            					$options.='';
				            				else
				            					$options.=',';
					            		}
		            				}
		            			$counter--;
				    		}
				    		$options.=']';
				    	if($counts==1)
							$options.='}';
						else
							$options.='},';
						$counts--;
					}
			$options.='],
		    "xAxis": {
		        "categories": [';
		        $count = count($months);
	            	foreach ($months as $month) {
	    				$options.= '"'.$month->label." ".$month->annum;
	    				if($count==1)
	    					$options.='" ';
	    				else
	    					$options.='" ,';
	    				$count--;
	    			}
	            $options.=']
		    },
		    "yAxis": {
		        "title": {
		            "text": "'.trans('messages.prevalence-rates-label').'"
		        },
	            "min": "0",
	            "max": "100"
		    }
		}';
	return $options;
	}
	//	Begin count reports functions
	/**
	 * Display a test((un)grouped) and specimen((un)grouped) counts.
	 *
	 */
	public function countReports(){
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$counts = Input::get('counts');
		//	Begin grouped test counts
		if($counts==trans('messages.grouped-test-counts'))
		{
			$testCategories = TestCategory::all();
			$testTypes = TestType::all();
			$ageRanges = array('0-5', '5-15', '15-120');	//	Age ranges - will definitely change in configurations
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perTestType = array();	//	array for counts data per testype
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			foreach ($testTypes as $testType) {
				$countAll = $testType->groupedTestCount(null, null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $testType->groupedTestCount([Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $testType->groupedTestCount([Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perTestType[$testType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $testType->groupedTestCount([Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $testType->groupedTestCount([Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$testType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
			}
			return View::make('reports.counts.groupedTestCount')
						->with('testCategories', $testCategories)
						->with('ageRanges', $ageRanges)
						->with('gender', $gender)
						->with('perTestType', $perTestType)
						->with('perAgeRange', $perAgeRange)
						->withInput(Input::all());
		}
		else if($counts==trans('messages.ungrouped-specimen-counts')){
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$ungroupedSpecimen = array();
			foreach (SpecimenType::all() as $specimenType) {
				$rejected = $specimenType->countPerStatus([Specimen::REJECTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$accepted = $specimenType->countPerStatus([Specimen::ACCEPTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$total = $rejected+$accepted;
				$ungroupedSpecimen[$specimenType->id] = ["total"=>$total, "rejected"=>$rejected, "accepted"=>$accepted];
			}

			// $data = $data->groupBy('test_type_id')->paginate(Config::get('kblis.page-items'));
			return View::make('reports.counts.ungroupedSpecimenCount')
							->with('ungroupedSpecimen', $ungroupedSpecimen)
							->withInput(Input::all());

		}
		else if($counts==trans('messages.grouped-specimen-counts')){
			$ageRanges = array('0-5', '5-15', '15-120');	//	Age ranges - will definitely change in configurations
			$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female

			$perAgeRange = array();	// array for counts data for each test type and age range
			$perSpecimenType = array();	//	array for counts data per testype
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			$specimenTypes = SpecimenType::all();
			foreach ($specimenTypes as $specimenType) {
				$countAll = $specimenType->groupedSpecimenCount([Patient::MALE, Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countMale = $specimenType->groupedSpecimenCount([Patient::MALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$countFemale = $specimenType->groupedSpecimenCount([Patient::FEMALE], null, $from, $toPlusOne->format('Y-m-d H:i:s'));
				$perSpecimenType[$specimenType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
				foreach ($ageRanges as $ageRange) {
					$maleCount = $specimenType->groupedSpecimenCount([Patient::MALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$femaleCount = $specimenType->groupedSpecimenCount([Patient::FEMALE], $ageRange, $from, $toPlusOne->format('Y-m-d H:i:s'));
					$perAgeRange[$specimenType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
				}
			}
			return View::make('reports.counts.groupedSpecimenCount')
						->with('specimenTypes', $specimenTypes)
						->with('ageRanges', $ageRanges)
						->with('gender', $gender)
						->with('perSpecimenType', $perSpecimenType)
						->with('perAgeRange', $perAgeRange)
						->withInput(Input::all());
		}
		else{
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
				Session::flash('message', trans('messages.check-date-range'));
			}

			$ungroupedTests = array();
			foreach (TestType::all() as $testType) {
				$pending = $testType->countPerStatus([Test::PENDING, Test::STARTED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$complete = $testType->countPerStatus([Test::COMPLETED, Test::VERIFIED], $from, $toPlusOne->format('Y-m-d H:i:s'));
				$ungroupedTests[$testType->id] = ["complete"=>$complete, "pending"=>$pending];
			}

			// $data = $data->groupBy('test_type_id')->paginate(Config::get('kblis.page-items'));
			return View::make('reports.counts.ungroupedTestCount')
							->with('ungroupedTests', $ungroupedTests)
							->withInput(Input::all());
		}
	}

	/*
	*	Begin turnaround time functions - functions related to the turnaround time report
	*	Most have been borrowed from the original BLIS by C4G
	*/
	/*
	* 	getPercentile() returns the percentile value from the given list
	*/
	public static function getPercentile($list, $ile_value)
	{
		$num_values = count($list);
		sort($list);
		$mark = ceil(round($ile_value/100, 2) * $num_values);
		return $list[$mark-1];
	}
	/*
	* 	week_to_date() returns timestamp for the first day of the week (Monday)
	*	@var $week_num and $year
	*/
	public static function week_to_date($week_num, $year)
	{
		# Returns timestamp for the first day of the week (Monday)
		$week = $week_num;
		$Jan1 = mktime (0, 0, 0, 1, 1, $year); //Midnight
		$iYearFirstWeekNum = (int) strftime("%W", $Jan1);
		if ($iYearFirstWeekNum == 1)
		{
			$week = $week - 1;
		}
		$weekdayJan1 = date ('w', $Jan1);
		$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1);
		$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday);
		return ($CurrentMondayTS);
	}
	/*
	* 	rawTaT() returns list of timestamps for tests that were registered and handled between date_from and date_to
	*	optional @var $from, $to, $labSection, $testType
	*/
	public static function rawTaT($from, $to, $labSection, $testType){
		$rawTat = DB::table('tests')->select(DB::raw('UNIX_TIMESTAMP(time_created) as timeCreated, UNIX_TIMESTAMP(time_started) as timeStarted, UNIX_TIMESTAMP(time_completed) as timeCompleted, targetTAT'))
						->join('test_types', 'test_types.id', '=', 'tests.test_type_id')
						->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
						if($from && $to){
							$rawTat = $rawTat->whereBetween('time_created', [$from, $to]);
						}
						else{
							$rawTat = $rawTat->where('time_created', 'LIKE', '%'.date("Y").'%');
						}
						if($labSection){
							$rawTat = $rawTat->where('test_category_id', $labSection);
						}
						if($testType){
							$rawTat = $rawTat->where('test_type_id', $testType);
						}
		return $rawTat->get();
	}
	/*
	* 	getTatStats() calculates Weekly progression of TAT values for a given test type and time period
	*	optional @var $from, $to, $labSection, $testType, $interval
	*/
	public static function getTatStats($from, $to, $labSection, $testType, $interval){
		# Calculates Weekly progression of TAT values for a given test type and time period

		$resultset = self::rawTaT($from, $to, $labSection, $testType);
		# {resultentry_ts, specimen_id, date_collected_ts, ...}

		$progression_val = array();
		$progression_count = array();
		$percentile_tofind = 90;
		$percentile_count = array();
		$goal_val = array();
		# Return {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids]]}

		if($interval == 'M'){
			foreach($resultset as $record)
			{
				$timeCreated = $record->timeCreated;
				$timeCreated_parsed = date("Y-m-d", $timeCreated);
				$timeCreated_parts = explode("-", $timeCreated_parsed);
				$month_ts = mktime(0, 0, 0, $timeCreated_parts[1], 0, $timeCreated_parts[0]);
				$month_ts_datetime = date("Y-m-d H:i:s", $month_ts);
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time

				if(!isset($progression_val[$month_ts]))
				{
					$progression_val[$month_ts] = array();
					$progression_val[$month_ts][0] = $date_diff;
					$progression_val[$month_ts][1] = $wait_diff;
					$progression_val[$month_ts][4] = array();
					$progression_val[$month_ts][4][] = $record;

					$percentile_count[$month_ts] = array();
					$percentile_count[$month_ts][] = $date_diff;

					$progression_count[$month_ts] = 1;

					if(!$record->targetTAT==null)
						$goal_tat[$month_ts] = $record->targetTAT; //Hours
					else
						$goal_tat[$month_ts] = 0.00; //Hours			
				}
				else
				{
					$progression_val[$month_ts][0] += $date_diff;
					$progression_val[$month_ts][1] += $wait_diff;
					$progression_val[$month_ts][4][] = $record;

					$percentile_count[$month_ts][] = $date_diff;

					$progression_count[$month_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		else if($interval == 'D'){
			foreach($resultset as $record)
			{
				$date_collected = $record->timeCreated;
				$day_ts = $date_collected; 
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time
				if(!isset($progression_val[$day_ts]))
				{
					$progression_val[$day_ts] = array();
					$progression_val[$day_ts][0] = $date_diff;
					$progression_val[$day_ts][1] = $wait_diff;
					$progression_val[$day_ts][4] = array();
					$progression_val[$day_ts][4][] = $record;

					$percentile_count[$day_ts] = array();
					$percentile_count[$day_ts][] = $date_diff;

					$progression_count[$day_ts] = 1;

					$goal_tat[$day_ts] = $record->targetTAT; //Hours
				}
				else
				{
					$progression_val[$day_ts][0] += $date_diff;
					$progression_val[$day_ts][1] += $wait_diff;
					$progression_val[$day_ts][4][] = $record;

					$percentile_count[$day_ts][] = $date_diff;

					$progression_count[$day_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		else{
			foreach($resultset as $record)
			{
				$date_collected = $record->timeCreated;
				$week_collected = date("W", $date_collected);
				$year_collected = date("Y", $date_collected);
				$week_ts = self::week_to_date($week_collected, $year_collected);
				$wait_diff = ($record->timeStarted - $record->timeCreated); //Waiting time
				$date_diff = ($record->timeCompleted - $record->timeStarted); //Turnaround time

				if(!isset($progression_val[$week_ts]))
				{
					$progression_val[$week_ts] = array();
					$progression_val[$week_ts][0] = $date_diff;
					$progression_val[$week_ts][1] = $wait_diff;
					$progression_val[$week_ts][4] = array();
					$progression_val[$week_ts][4][] = $record;

					$percentile_count[$week_ts] = array();
					$percentile_count[$week_ts][] = $date_diff;

					$progression_count[$week_ts] = 1;

					if(!$record->targetTAT==null)
						$goal_tat[$week_ts] = $record->targetTAT; //Hours
					else
						$goal_tat[$week_ts] = 0.00; //Hours				
				}
				else
				{
					$progression_val[$week_ts][0] += $date_diff;
					$progression_val[$week_ts][1] += $wait_diff;
					$progression_val[$week_ts][4][] = $record;

					$percentile_count[$week_ts][] = $date_diff;

					$progression_count[$week_ts] += 1;
				}
			}

			foreach($progression_val as $key=>$value)
			{
				# Find average TAT
				$progression_val[$key][0] = $value[0]/$progression_count[$key];

				# Determine percentile value
				$progression_val[$key][3] = self::getPercentile($percentile_count[$key], $percentile_tofind);

				# Convert from sec timestamp to Hours
				$progression_val[$key][0] = ($value[0]/$progression_count[$key])/(60*60);//average TAT
				$progression_val[$key][1] = ($value[1]/$progression_count[$key])/(60*60);//average WT
				$progression_val[$key][3] = $progression_val[$key][3]/(60*60);// Percentile ???

				$progression_val[$key][2] = $goal_tat[$key];

			}
		}
		# Return {month=>[avg tat, percentile tat, goal tat, [overdue specimen_ids], [pending specimen_ids], avg wait time]}
		return $progression_val;
	}

	/**
	 * turnaroundTime() function returns the turnaround time blade with necessary contents
	 *
	 * @return Response
	 */
	public function turnaroundTime()
	{
		$today = date('Y-m-d');
		$from = Input::get('start');
		$to = Input::get('end');
		if(!$to){
			$to=$today;
		}
		$testCategory = Input::get('section_id');
		$testType = Input::get('test_type');
		$labSections = TestCategory::lists('name', 'id');
		$interval = Input::get('period');
		$error = null;

		if($testCategory)
			$testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
		else
			$testTypes = array(""=>"");

		if($from||$to){
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
					$error = trans('messages.check-date-range');
			}
			else
			{
				$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
				Session::flash('fine', '');
			}
		}
		$resultset = self::getTatStats($from, $to, $testCategory, $testType, $interval);
		return View::make('reports.tat.index')
					->with('labSections', $labSections)
					->with('testTypes', $testTypes)
					->with('resultset', $resultset)
					->with('testCategory', $testCategory)
					->with('testType', $testType)
					->with('interval', $interval)
					->with('error', $error)
					->withInput(Input::all());
	}

	//	Begin infection reports functions
	/**
	 * Display a table containing all infection statistics.
	 *
	 */
	public function infectionReport(){

	 	$ageRanges = array('0-5'=>'Under 5 years', 
	 					'5-14'=>'5 years and over but under 14 years', 
	 					'14-120'=>'14 years and above');	//	Age ranges - will definitely change in configurations
		$gender = array(Patient::MALE, Patient::FEMALE); 	//	Array for gender - male/female
		$ranges = array('Low', 'Normal', 'High');

		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');

		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));

		$testCategory = Input::get('test_category');

		$infectionData = Test::getInfectionData($from, $toPlusOne, $testCategory);	// array for counts data for each test type and age range
		
		return View::make('reports.infection.index')
					->with('gender', $gender)
					->with('ageRanges', $ageRanges)
					->with('ranges', $ranges)
					->with('infectionData', $infectionData)
					->withInput(Input::all());
	}

	/**
	 * Displays summary statistics on users application usage.
	 *
	 */
	public function userStatistics(){

		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');

		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$selectedUser = Input::get('user');
		if(!$selectedUser)$selectedUser = "";
		else $selectedUser = " USER: ".User::find($selectedUser)->name;

		$reportTypes = array('Summary', 'Patient Registry', 'Specimen Registry', 'Tests Registry', 'Tests Performed');

		$selectedReport = Input::get('report_type');
		if(!$selectedReport)$selectedReport = 0;

		switch ($selectedReport) {
			case '1':
				$reportData = User::getPatientsRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-patients-register-report-title',1);
				break;
			case '2':
				$reportData = User::getSpecimensRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-specimens-register-report-title',1);
				break;
			case '3':
				$reportData = User::getTestsRegistered($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-tests-register-report-title',1);
				break;
			case '4':
				$reportData = User::getTestsPerformed($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-tests-performed-report-title',1);
				break;
			default:
				$reportData = User::getSummaryUserStatistics($from, $to.' 23:59:59', Input::get('user'));
				$reportTitle = Lang::choice('messages.user-statistics-summary-report-title',1);
				break;
		}

		$reportTitle = str_replace("[FROM]", $from, $reportTitle);
		$reportTitle = str_replace("[TO]", $to, $reportTitle);
		$reportTitle = str_replace("[USER]", $selectedUser, $reportTitle);
		
		return View::make('reports.userstatistics.index')
					->with('reportTypes', $reportTypes)
					->with('reportData', $reportData)
					->with('reportTitle', $reportTitle)
					->with('selectedReport', $selectedReport)
					->withInput(Input::all());
	}
	/**
	 * MOH 706
	 *
	 */
	public function moh706(){
		//	Variables definition
		$date = date('Y-m-03');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$ageRanges = array('0-5', '5-14', '14-120');
		$sex = array(Patient::MALE, Patient::FEMALE);
		$ranges = array('Low', 'Normal', 'High');
		$specimen_types = array('Urine', 'Pus', 'HVS', 'Throat', 'Stool', 'Blood', 'CSF', 'Water', 'Food', 'Other fluids');
		$isolates = array('Naisseria', 'Klebsiella', 'Staphylococci', 'Streptoccoci'. 'Proteus', 'Shigella', 'Salmonella', 'V. cholera', 
						  'E. coli', 'C. neoformans', 'Cardinella vaginalis', 'Haemophilus', 'Bordotella pertusis', 'Pseudomonas', 
						  'Coliforms', 'Faecal coliforms', 'Enterococcus faecalis', 'Total viable counts-22C', 'Total viable counts-37C', 
						  'Clostridium', 'Others');

		//	Get specimen_types for microbiology
		$labSecId = TestCategory::getTestCatIdByName('microbiology');
		$specTypeIds = DB::select(DB::raw("select distinct(specimen_types.id) as spec_id from testtype_specimentypes".
										  " join test_types on test_types.id=testtype_specimentypes.test_type_id".
										  " join specimen_types on testtype_specimentypes.specimen_type_id=specimen_types.id".
										  "  where test_types.test_category_id=?"), array($labSecId));

		//	Referred out specimen
		$referredSpecimens = DB::select(DB::raw("SELECT specimen_type_id, specimen_types.name as spec, count(specimens.id) as tot,".
												" facility_id, facilities.name as facility FROM iblis.specimens".
												" join referrals on specimens.referral_id=referrals.id".
												" join specimen_types on specimen_type_id=specimen_types.id".
												" join facilities on referrals.facility_id=facilities.id".
												" where referral_id is not null and status=1".
												" and time_accepted between ? and ?".
												" group by facility_id;"), array($from, $toPlusOne));
		$table = '<!-- URINALYSIS -->
					<div class="col-sm-2">
						<strong>URINE ANALYSIS</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th colspan="2">No. Exam</th>
									<th colspan="4"> Number positive</th>
								</tr>
								<tr>
									<th>M</th>
									<th>F</th>
									<th>Total</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>';
						$urineChem = TestType::getTestTypeIdByTestName('Urine Chemistry');
						$urineChemistry = TestType::find($urineChem);
						$measures = TestTypeMeasure::where('test_type_id', $urineChem)->orderBy('measure_id', 'DESC')->get();
						$table.='<tbody>
								<tr>
									<td colspan="7"><strong>Urine Chemistry</strong></td>
								</tr>
								<tr>
									<td>Totals</td>';
								foreach ($sex as $gender) {
									$table.='<td>'.$urineChemistry->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
								}
								$table.='<td>'.$urineChemistry->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
								foreach ($ageRanges as $ageRange) {
									$table.='<td>'.$urineChemistry->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
								}	
							$table.='</tr>';
						
						foreach ($measures as $measure) {
							$tMeasure = Measure::find($measure->measure_id);
							$table.='<tr>
										<td>'.$tMeasure->name.'</td>';
									foreach ($sex as $gender) {
										$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne).'</td>';
									}
									$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne).'</td>';
									foreach ($ageRanges as $ageRange) {
										$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne).'</td>';
									}
									$table.='</tr>';
						}

						$table.='<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7"><strong>Urine Microscopy</strong></td>
								</tr>
								<tr>
									<td>Totals</td>';
						$urineMic = TestType::getTestTypeIdByTestName('Urine Microscopy');
						$urineMicroscopy = TestType::find($urineMic);
						$measures = TestTypeMeasure::where('test_type_id', $urineMic)->orderBy('measure_id', 'DESC')->get();
								foreach ($sex as $gender) {
									$table.='<td>'.$urineMicroscopy->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
								}
								$table.='<td>'.$urineMicroscopy->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
								foreach ($ageRanges as $ageRange) {
									$table.='<td>'.$urineMicroscopy->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
								}	
							$table.='</tr>';
						
						foreach ($measures as $measure) {
							$tMeasure = Measure::find($measure->measure_id);
							$table.='<tr>
										<td>'.$tMeasure->name.'</td>';
									foreach ($sex as $gender) {
										$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne).'</td>';
									}
									$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne).'</td>';
									foreach ($ageRanges as $ageRange) {
										$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne).'</td>';
									}
									$table.='</tr>';
						}
						$table.='<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<strong>
										<th></th>
										<th>M</th>
										<td>F</td>
										<td>Total</td>
										<td>Low</td>
										<td>Normal</td>
										<td>High</td>
									</strong>
								</tr>
								<tr>
									<td colspan="7"><strong>Blood Chemistry</strong></td>
								</tr>';
						$bloodChem = TestType::getTestTypeIdByTestName('Blood Sugar');
						$bloodChemistry = TestType::find($bloodChem);
						$total = DB::table('tests')
				                     ->where('test_type_id', $bloodChem)
				                     ->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED])
				                     ->where('time_created', 'LIKE', '%' .date('Y-m'). '%')
				                     ->get();
							$table.='<tr>
									<td>Totals</td>';
							foreach ($sex as $gender) {
								$table.='<td>'.$bloodChemistry->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
							}
							$table.='<td>'.$bloodChemistry->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$bloodChemistry->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
							}	
							$table.='<tr>
									<td>Fasting blood sugar</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Random blood sugar</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>OGTT</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7"><strong>Renal function tests</strong></td>
								</tr>';
						$rfts = TestType::getTestTypeIdByTestName('RFTS');
						$rft = TestType::find($rfts);
						$measures = TestTypeMeasure::where('test_type_id', $rfts)->orderBy('measure_id', 'DESC')->get();
						$total = DB::table('tests')
				                     ->where('test_type_id', $rfts)
				                     ->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED])
				                     ->where('time_created', 'LIKE', '%' .date('Y-m'). '%')
				                     ->get();
			                $table.='<tr>
								<td>Totals</td>';
			        		foreach ($sex as $gender) {
								$table.='<td>'.$rft->groupedTestCount([$gender], null, $from, $toPlusOne).'</td>';
							}
							$table.='<td>'.$rft->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$rft->groupedTestCount([Patient::MALE, Patient::FEMALE], $ageRange, $from, $toPlusOne).'</td>';
							}	
						$table.='</tr>';
						foreach ($measures as $measure) {
							$name = Measure::find($measure->measure_id)->name;
							if($name == 'Electrolytes'){
								continue;
							}
							$tMeasure = Measure::find($measure->measure_id);
							$table.='<tr>
										<td>'.$tMeasure->name.'</td>';
									foreach ($sex as $gender) {
										$table.='<td>'.$tMeasure->totalTestResults([$gender], null, $from, $toPlusOne).'</td>';
									}
									$table.='<td>'.$tMeasure->totalTestResults($sex, null, $from, $toPlusOne).'</td>';
									foreach ($ranges as $range) {
										$table.='<td>'.$tMeasure->totalTestResults(null, $ageRange, $from, $toPlusOne, $range).'</td>';
									}
									$table.='</tr>';
						}
						$table.='<tr>
									<td colspan="7"><strong>Liver Function Tests</strong></td>
								</tr>';
						$lfts = TestType::getTestTypeIdByTestName('LFTS');
						$measures = TestTypeMeasure::where('test_type_id', $lfts)->orderBy('measure_id', 'DESC')->get();
						$total = DB::table('tests')
				                     ->where('test_type_id', $lfts)
				                     ->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED])
				                     ->where('time_created', 'LIKE', '%' .date('Y-m'). '%')
				                     ->get();
							$table.='<tr>
									<td>Totals</td>
									<td></td>
									<td></td>
									<td>'.count($total).'</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>';
						foreach ($measures as $measure) {
							$name = Measure::find($measure->measure_id)->name;
							if($name == 'SGOT'){
								$name = 'ASAT (SGOT)';
							}
							if($name == 'ALAT'){
								$name = 'ASAT (SGPT)';
							}
							if($name == 'Total Proteins'){
								$name = 'Serum Protein';
							}
							$table.='<tr>
									<td>'.$name.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>';
						}
						$table.='<tr>
									<td>Gamma GT</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7"><strong>Lipid Profile</strong></td>
								</tr>
								<tr>
									<td>Totals</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
								</tr>
								<tr>
									<td>Amylase</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Total cholestrol</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Trigycerides</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>HDL</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>LDE</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>PSA</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7"><strong>CSF Chemistry</strong></td>
								</tr>
								<tr>
									<td>Totals</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
								</tr>';
						$csf = TestType::getTestTypeIdByTestName('CSF for biochemistry');
						$measures = TestTypeMeasure::where('test_type_id', $csf)->orderBy('measure_id', 'DESC')->get();
						foreach ($measures as $measure) {
							$name = Measure::find($measure->measure_id)->name;
							$table.='<tr>
									<td>'.$name.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>';
						}
						$table.='<tr>
									<td colspan="7"><strong>Body Fluids</strong></td>
								</tr>
								<tr>
									<td>Totals</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
								</tr>
								<tr>
									<td>Proteins</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Glucose</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Acid phosphatase</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Bence jones protein</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="7"><strong>Thyroid Function Tests</strong></td>
								</tr>
								<tr>
									<td>Totals</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
									<td>0</td>
								</tr>';
						$tfts = TestType::getTestTypeIdByTestName('TFT');
						$measures = TestTypeMeasure::where('test_type_id', $tfts)->orderBy('measure_id', 'ASC')->get();
						foreach ($measures as $measure) {
							$name = Measure::find($measure->measure_id)->name;
							if($name == 'FT3'){
								$name = 'T3';
							}
							if($name == 'FT4'){
								$name = 'T4';
							}
							$table.='<tr>
									<td>'.$name.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>';
						}
						$table.='<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- URINALYSIS -->
					<!-- PARASITOLOGY -->
					<!-- Paratitology -->
					<div class="col-sm-2">
						<strong>PARASITOLOGY</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th colspan="5">Blood Smears</th>
								</tr>
								<tr>
									<th rowspan="2">Malaria</th>
									<th colspan="4">Positive</th>
								</tr>
								<tr>
									<th>Total Done</th>
									<th>&lt;5yrs</th>
									<th>5-14yrs</th>
									<th>&gt;14yrs</th>
								</tr>
							</thead>';
						$bs = TestType::getTestTypeIdByTestName('Bs for mps');
						$bs4mps = TestType::find($bs);
						$table.='<tbody>
								<tr>
									<td></td>
									<td>'.$bs4mps->groupedTestCount(null, null, $from, $toPlusOne).'</td>';
							foreach ($ageRanges as $ageRange) {
								$table.='<td>'.$bs4mps->groupedTestCount(null, $ageRange, $from, $toPlusOne).'</td>';
							}
							$table.='</tr>
								<tr style="text-align:right;">
									<td>Falciparum</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Ovale</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Malariae</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="text-align:right;">
									<td>Vivax</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Borrelia</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Microfilariae</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td><strong>Trypanosomes</strong></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5"><strong>Genital Smears</strong></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>T. vaginalis</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>S. haematobium</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Yeast cells</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5"><strong>Spleen/bone marrow</strong></td>
								</tr>
								<tr>
									<td>Total</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>L. donovani</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td colspan="5"><strong>Stool</strong></td>
								</tr>
								<tr>
									<td colspan="5">Total</td>
								</tr>
								<tr>
									<td>Taenia spp.</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>H. nana</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>H. Diminuta</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hookworm</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Roundworms</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>S. mansoni</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Trichuris trichiura</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Strongyloides stercoralis</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Isospora belli</td>
									<td style="background-color: #CCCCCC;"></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td rowspan="2">E hystolytica</td>
									<td>cysts</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>trophozoites</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td  rowspan="2">Giardia lamblia</td>
									<td>cysts</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>trophozoites</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cryptosporidium</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cyclospora</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5"><strong>Skin snips</strong></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Onchocerca volvulus</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Leishmania</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5"><strong>Lavages</strong></td>
								</tr>
								<tr>
									<td>Total</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- PARASITOLOGY -->
					<!-- BACTERIOLOGY -->
					<div class="col-sm-4">
						<strong>BACTERIOLOGY</strong>
						<div class="row">
							<div class="col-sm-3">
								<table class="table table-condensed report-table-border" style="padding-right:5px;">
									<tbody style="text-align:right;">
										<tr>
											<td>Total examinations done</td>
											<td></td>
										</tr>';
								foreach ($specTypeIds as $key) {
									if(in_array(SpecimenType::find($key->spec_id)->name, ['Aspirate', 'Pleural Tap', 'Synovial Fluid', 'Sputum', 'Ascitic Tap', 'Semen', 'Skin'])){
										continue;
									}
									$totalCount = DB::select(DB::raw("select count(specimen_id) as per_spec_count from tests".
																	 " join specimens on tests.specimen_id=specimens.id".
																	 " join test_types on tests.test_type_id=test_types.id".
																	 " where specimens.specimen_type_id=?".
																	 " and test_types.test_category_id=?".
																	 " and test_status_id in(?,?)".
																	 " and tests.time_created BETWEEN ? and ?;"), 
																	[$key->spec_id, $labSecId, Test::COMPLETED, Test::VERIFIED, $from, $toPlusOne]);
									$table.='<tr>
											<td>'.SpecimenType::find($key->spec_id)->name.'</td>
											<td>'.$totalCount[0]->per_spec_count.'</td>
										</tr>';
								}
								$table.='</tr>
											<td>Rectal swab</td>
											<td>0</td>
										</tr>
										</tr>
											<td>Water</td>
											<td>0</td>
										</tr>
										</tr>
											<td>Food</td>
											<td>0</td>
										</tr>
										</tr>
											<td>Other (specify)....</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-2">
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td colspan="3">Drugs</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3">Sensitivity (Total done)</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="3">Resistance per drug</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="3">KOH Preparations</td>
											<td>Fungi</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td colspan="2">Others (specify)</td>
										</tr>
										<tr>
											<td>Others</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>...</td>
											<td></td>
										</tr>
										<tr>
											<td>Total</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td>...</td>
											<td></td>
										</tr>
									</tbody>
								</table>
								<p>SPUTUM</p>
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td></td>
											<td>Total</td>
											<td>Positive</td>
										</tr>
										<tr>
											<td>TB new suspects</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>Followup</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>TB smears</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td>MDR</td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<table class="table table-condensed report-table-border">
							<tbody>
								<tr><td></td>';
							foreach ($specimen_types as $spec) {
								$table.='<td>'.$spec.'</td>';
							}	
							$table.='</tr>';
							foreach ($isolates as $isolate) {
								$table.='<tr>
									<td>'.$isolate.'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>';
							}
							$table.='<tr>
									<td colspan="11">Specify species of each isolate</td>
								</tr>
							</tbody>
						</table>
						<div class="row">
							<div class="col-sm-6">
								<strong>HEMATOLOGY REPORT</strong>
								<table class="table table-condensed report-table-border">
									<thead>
										<tr>
											<th colspan="2">Type of examination</th>
											<th>No. of Tests</th>
											<th>Controls</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="2">Full blood count</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Full haemogram'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Manual WBC counts</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Peripheral blood films</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Erythrocyte Sedimentation rate</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('ESR'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Sickling test</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Sickling test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">HB electrophoresis</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">G6PD screening</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Bleeding time</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Bleeding time test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Clotting time</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Clotting time test'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Prothrombin test</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Partial prothrombin time</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td colspan="2">Bone Marrow Aspirates</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td colspan="2">Reticulocyte counts</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td colspan="2">Others</td>
											<td></td>
											<td style="background-color: #CCCCCC;"></td>
										</tr>
										<tr>
											<td rowspan="2">Haemoglobin</td>
											<td>No. Tests</td>
											<td>&lt;5</td>
											<td>5&lt;Hb&lt;10</td>
										</tr>
										<tr>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('HB'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">CD4/CD8</td>
											<td>No. Tests</td>
											<td>&lt;200</td>
											<td>200-350</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">CD4%</td>
											<td>No. Tests</td>
											<td>&lt;25%</td>
											<td>&gt;25%</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">Peripheral Blood Films</td>
											<td>Parasites</td>
											<td colspan="2">No. smears with inclusions</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td colspan="2"></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-1">
								<strong>BLOOD GROUPING AND CROSSMATCH REPORT</strong>
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td>Total groupings done</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('GXM'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
										<tr>
											<td>Blood units grouped</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Blood Grouping'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
										<tr>
											<td>Total transfusion reactions</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood cross matches</td>
											<td>'.TestType::find(TestType::getTestTypeIdByTestName('Cross Match'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
										</tr>
									</tbody>
								</table>
								<br />
								<strong>Blood safety</strong>
								<table class="table table-condensed report-table-border">
									<tbody>
										<tr>
											<td>Measure</td>
											<td>Number</td>
										</tr>
										<tr>
											<td>A. Blood units collected from regional blood transfusion centres</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units collected from other centres and screened at health facility</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units screened at health facility that are HIV positive</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units screened at health facility that are Hepatitis positive</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units positive for other infections</td>
											<td></td>
										</tr>
										<tr>
											<td>Blood units transfered</td>
											<td></td>
										</tr>
										<tr>
											<td rowspan="2">General remarks .............................</td>
											<td rowspan="2"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- BACTERIOLOGY -->
					<!-- HISTOLOGY AND CYTOLOGY -->
					<div class="col-sm-4">
						<strong>HISTOLOGY AND CYTOLOGY REPORT</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th rowspan="2">Total</th>
									<th rowspan="2">Normal</th>
									<th rowspan="2">Infective</th>
									<th colspan="2">Non-infective</th>
									<th colspan="3">Positive findings</th>
								</tr>
								<tr>
									<th>Benign</th>
									<th>Malignant</th>
									<th>&lt;5 yrs</th>
									<th>5-14 yrs</th>
									<th>&gt;14 yrs</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td colspan="9">SMEARS</td>
								</tr>
								<tr>
									<td>Pap Smear</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Tissue Impressions</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td colspan="9">TISSUE ASPIRATES (FNA)</td>
								</tr>
								<tr>
									<td></td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td colspan="9">FLUID CYTOLOGY</td>
								</tr>
								<tr>
									<td>Ascitic fluid</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>CSF</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Pleural fluid</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td colspan="9">TISSUE HISTOLOGY</td>
								</tr>
								<tr>
									<td>Cervix</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Prostrate</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Breast</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Ovarian cyst</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Fibroids</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Lymph nodes</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
									<td>N/S</td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<strong>SEROLOGY REPORT</strong>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th rowspan="2">Serological test</th>
									<th colspan="2">Total</th>
									<th colspan="2">&lt;5 yrs</th>
									<th colspan="2">5-14 yrs</th>
									<th colspan="2">&gt;14 yrs</th>
								</tr>
								<tr>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
									<th>Tested</th>
									<th>No. +ve</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Rapid Plasma Region</td>';
									foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL')) as $count){
										if(count($count)==0)
											{
												$count->total=0;
												$count->positive=0;
											}
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
									foreach ($ageRanges as $ageRange) {
										if(count(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL'), $ageRange))==0)
										{
											$table.='<td>0</td>
											<td>0</td>';
										}
										else{
											foreach(TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('VDRL'), $ageRange) as $count){
												$table.='<td>'.$count->total.'</td>
												<td>'.$count->positive.'</td>';
											}
										}
									}
									$table.='</tr>
								<tr>
									<td>TPHA</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>ASO Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>HIV Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Widal Test</td>';
									$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Widal'));
									if(count($data)==0)
									{
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
									else{
										foreach($data as $count){
											$table.='<td>'.$count->total.'</td>
											<td>'.$count->positive.'</td>';
										}
									}
									foreach ($ageRanges as $ageRange) {
										$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Widal'), $ageRange);
										if(count($data)==0)
										{
											$table.='<td>0</td>
											<td>0</td>';
										}
										else{
											foreach($data as $count){
												$table.='<td>'.$count->total.'</td>
												<td>'.$count->positive.'</td>';
											}
										}
									}
									$table.='</tr>
								<tr>
									<td>Brucella Test</td>';
									$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Brucella'));
									if(count($data)==0)
									{
										$table.='<td>'.$count->total.'</td>
										<td>'.$count->positive.'</td>';
									}
									else{
										foreach($data as $count){
											$table.='<td>'.$count->total.'</td>
											<td>'.$count->positive.'</td>';
										}
									}
									foreach ($ageRanges as $ageRange) {
										$data = TestType::getPrevalenceCounts($from, $to, TestType::getTestTypeIdByTestName('Brucella'), $ageRange);
										if(count($data)==0)
										{
											$table.='<td>0</td>
											<td>0</td>';
										}
										else{
											foreach($data as $count){
												$table.='<td>'.$count->total.'</td>
												<td>'.$count->positive.'</td>';
											}
										}
									}
									$table.='</tr>
								<tr>
									<td>Rheumatoid Factor Tests</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('RF'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Cryptococcal Antigen</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Helicobacter pylori test</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('H pylori'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis A test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis B test</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Hepatitis B'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Hepatitis C test</td>
									<td>'.TestType::find(TestType::getTestTypeIdByTestName('Hepatitis C'))->groupedTestCount(null, null, $from, $toPlusOne).'</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Viral Load</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Formal Gel Test</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Other Tests</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<br />
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th>Dried Blood Spots</th>
									<th>Tested</th>
									<th># +ve</th>
									<th>Discrepant</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Early Infant Diagnosis of HIV</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Quality Assurance</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Discordant couples</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Others</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						<p><strong>Specimen referral to higher levels</strong></p>
						<table class="table table-condensed report-table-border">
							<thead>
								<tr>
									<th>Specimen</th>
									<th>No</th>
									<th>Sent to</th>
									<th>No. of Reports/results received</th>
								</tr>
							</thead>
							<tbody>';
						if($referredSpecimens){
							foreach ($referredSpecimens as $referredSpecimen) {
								$table.='<tr>
										<td>'.$referredSpecimen->spec.'</td>
										<td>'.$referredSpecimen->tot.'</td>
										<td>'.$referredSpecimen->facility.'</td>
										<td></td>
									</tr>';
							}
						}else{
							$table.='<tr>
										<td colspan="4">'.trans('messages.no-records-found').'</td>
									</tr>';
						}
						$table.='</tbody>
						</table>
					</div>
					<!-- HISTOLOGY AND CYTOLOGY -->';

		return View::make('reports.moh.index')->with('table', $table);
	}	
}
