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

		$patients = Patient::search($search)->paginate(Config::get('kblis.page-items'));

		if (count($patients) == 0) {
		 	Session::flash('message', trans('messages.no-match'));
		}

		// Load the view and pass the patients
		return View::make('reports.patient.index')->with('patients', $patients);
	}

	/**
	 * Display data after applying the filters on the report uses patient ID
	 *
	 * @return Response
	 */
	public function viewPatientReport($id){
		$from = Input::get('start');
		$to = Input::get('end');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		//	Check checkbox if checked and assign the 'checked' value
		if (Input::get('tests') === '1') {
		    $pending='checked';
		}
		//	Query to get tests of a particular patient
		$tests = Test::join('visits', 'visits.id', '=', 'tests.visit_id')
					->where('patient_id', '=', $id);
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
					Session::flash('error', trans('messages.check-date-range'));
			}
			else
			{
				$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
				$tests=$tests->whereBetween('time_created', array($from, $toPlusOne));
			}
		}
		else
		{
			$tests = $tests->where('tests.time_created', 'LIKE', '%'.date('Y-m-d').'%');
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
							->with('to', $to);
	    	return Response::make($content,200, $headers);
		}
		else{
			return View::make('reports.patient.report')
						->with('patient', $patient)
						->with('tests', $tests)
						->with('pending', $pending)
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
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$all = Input::get('all');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		if(!$to){
			$to=$date;
		}
		$records = Input::get('records');
		$testCategory = Input::get('section_id');
		$testType = Input::get('test_type');
		$date = date('Y-m-d');
		$labSections = TestCategory::lists('name', 'id');
		if($testCategory)
			$testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
		else
			$testTypes = array(""=>"");
		
		if($records=='patients'){
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						Session::flash('error', trans('messages.check-date-range'));
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
								->with('from', $from)
								->with('to', $to);
		    	return Response::make($content,200, $headers);
			}
			else{
				return View::make('reports.daily.patient')
								->with('visits', $visits)
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
						Session::flash('message', trans('messages.check-date-range'));
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
								->with('to', $to)
								->with('from', $from);
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
			if($pending){
				$tests = $tests->whereIn('test_status_id', [Test::PENDING, Test::STARTED]);
			}
			else if($all){
				$tests = $tests->whereIn('test_status_id', 
					[Test::PENDING, Test::STARTED, Test::COMPLETED, Test::VERIFIED]);
			}
			else{
				$tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
			}
			/*Get collection of tests*/
			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						Session::flash('message', trans('messages.check-date-range'));
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
								->with('pending', $pending)
								->with('all', $all)
								->with('from', $from)
								->with('to',$to);
		    	return Response::make($content,200, $headers);
			}
			else
			{
				return View::make('reports.daily.test')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('tests', $tests)
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('pending', $pending)
							->with('all', $all)
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
		//	Apply filters if any
		if(Input::has('filter')){
			if(!$to){
				$to=$today;
			}
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($today)||strtotime($to)>strtotime($today)){
				Session::flash('message', trans('messages.check-date-range'));
			}
			$months = json_decode(self::getMonths($from, $to));
			$data = TestType::getPrevalenceCounts($from, $to);
			$chart = self::getPrevalenceRatesChart();
		}
		else{
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
	public static function getPrevalenceRatesChart(){
		$from = Input::get('start');
		$to = Input::get('end');
		$months = json_decode(self::getMonths($from, $to));
		$testTypes = new Illuminate\Database\Eloquent\Collection();

		$measures = Measure::where('measure_range', 'LIKE', '%Positive/Negative%')->get();

		foreach ($measures as $measure) {
			$objArray = $measure->testTypes()->first();
			if(!empty($objArray)){
				foreach ($measure->testTypes()->get() as $tType) {
					$testTypes->add($tType);
				}
			}
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
}
