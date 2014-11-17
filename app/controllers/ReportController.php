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
		$from = Input::get('start');
		$to = Input::get('end');
		if($search||$from||$to){
			$patients = Patient::where('id', 'LIKE', '%'.$search.'%')
								->orWhere('patient_number', 'LIKE', '%'.$search.'%')
								->orWhere('name', 'LIKE', '%'.$search.'%')
								->orWhere('external_patient_number', 'LIKE', '%'.$search.'%');
			$patients=$patients->paginate(Config::get('kblis.page-items'));
			if (count($patients) == 0) {
			 	Session::flash('message', 'Your search <b>'.$search.'</b>, did not match any patient record!');
			}
			else{
				Session::flash('message', 'Your search <b>'.$search.'</b>, matched the following patient records.');
			}
		}
		else{
			// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));
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
			if(!$to){
				$to = $date;
			}
			if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
					Session::flash('error', 'Please check your dates range and try again!');
			}
			else{
				$tests=$tests->whereRaw('tests.time_created BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)');
			}
		}
		else{
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
						->with('from', $from)
						->with('to', $to)
						->with('pending', $pending);
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
		$all = Input::get('all');
		$pending = Input::get('pending');
		$date = date('Y-m-d');
		$records = Input::get('records');
		$testCategory = Input::get('section_id');
		$testType = '';
		if(Input::get('test_type')){
			$testType = Input::get('test_type');
		}
		else if(Input::get('test_type_id')){
			$testType = Input::get('test_type_id');
		}
		$date = date('Y-m-d');
		$labSections = TestCategory::lists('name', 'id');
		$testTypes = TestType::all();
		
		if($records=='patients'){
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						Session::flash('error', 'Please check your dates range and try again!');
				}
				else{
					$visits = Visit::whereRaw('created_at BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)')->get();
				}
				if (count($visits) == 0) {
				 	Session::flash('message', 'Your filter from <b>'.$from.'</b> to <b>'.$to.'</b>, did not match any records!');
				}
				else{
					Session::flash('message', 'Your filter from <b>'.$from.'</b> to <b>'.$to.'</b>, matched the following records.');
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
								->with('from', $from)
								->with('to', $to);
			}
		}
		//Begin specimen rejections
		else if($records=='rejections'){
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
						Session::flash('message', 'Please check your dates range and try again!');
				}
				else{
					$specimens = $specimens->whereRaw('time_rejected BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)')
											->get(array('specimens.*'));
				}
			}
			else{
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
								->with('from', $from)
								->with('to', $to);
		    	return Response::make($content,200, $headers);
			}
			else{
				return View::make('reports.daily.specimen')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('specimens', $specimens)
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('from', $from)
							->with('to', $to);
			}
		}
		//Begin test records
		else{
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
				$tests = $tests->whereIn('test_status_id', [Test::PENDING, Test::STARTED, Test::COMPLETED, Test::VERIFIED]);
			}
			else{
				$tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
			}
			/*Get collection of tests*/
			/*Filter by date*/
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime($date)||strtotime($to)>strtotime($date)){
						Session::flash('message', 'Please check your dates range and try again!');
				}
				else{
					$tests = $tests->whereRaw('time_created BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)')
									->get(array('tests.*'));
				}
			}
			else{
				$tests = $tests->where('time_created', 'LIKE', $date.'%')
								->get(array('tests.*'));
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
								->with('to', $to);
		    	return Response::make($content,200, $headers);
			}
			else{
				return View::make('reports.daily.test')
							->with('labSections', $labSections)
							->with('testTypes', $testTypes)
							->with('tests', $tests)
							->with('testCategory', $testCategory)
							->with('testType', $testType)
							->with('pending', $pending)
							->with('all', $all)
							->with('from', $from)
							->with('to', $to);
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
		$year = date('Y');
		$periods = self::loadMonths($year);
		foreach ($periods as $period) {
			$data = self::getPrevalenceCounts($period->start, $period->end);
		}
		return View::make('reports.prevalence.index')
					->with('data', $data);
	}
	/**
	* Load months: Load time period in months when filter dates are not set
	*/
	public static function loadMonths($year){
		$months = Test::select(DB::raw('MIN(time_created) as start, MAX(time_created) as end'))
							->whereRaw('YEAR(time_created) = '.$year)
							->get();
		return $months;
	}
	/**
	* Get months: return months for time_created column when filter dates are set
	*/	
	public static function getMonths($from, $to){
		$today = "'".date("Y-m-d")."'";
		$year = date('Y');
		$dates = Test::select(DB::raw('DISTINCT MONTH(time_created) as months, LEFT(MONTHNAME(time_created), 3) as label, YEAR(time_created) as annum'));
		if(strtotime($from)===strtotime($today)){
			$dates->whereRaw('YEAR(time_created) = '.$year);
		}
		else{
			$dates->whereRaw('time_created BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)');
		}
		return $dates->orderBy('time_created', 'ASC')->get();
	}
	/**
	 * Display prevalence rates chart
	 *
	 * @return Response
	 */
	public static function getPrevalenceRatesChart(){
		$from = Input::get('start');
		$to = Input::get('end');
		$months = self::getMonths($from, $to);
		$test_types = TestType::select('test_types.id', 'test_types.name')
							->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
            				->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
            				->where('measure_range', 'LIKE', '%Positive/Negative%')
            				->get();

		$chart = '{
	       "chart": {
	        "caption": "Prevalence Rates",
	        "subcaption": ';
	        if($from==$to)
	        	$chart.='"For the year '.date('Y').'",';
	        else
	        	$chart.='"From '.$from.' To '.$to.'",';
            $chart.='"xaxisname": "Time",
            "yaxisname": "Prevalence Rates (In %)",
	        "linethickness": "1",
	        "exportEnabled":"1",
	        "showvalues": "0",
	        "formatnumberscale": "0",
	        "numbersuffix": "%",
	        "anchorradius": "2",
	        "divlinecolor": "666666",
	        "divlinealpha": "30",
	        "divlineisdashed": "1",
	        "labelstep": "1",
	        "bgcolor": "FFFFFF",
	        "showalternatehgridcolor": "0",
	        "labelpadding": "10",
			"canvasborderthickness": "1",
	        "legendiconscale": "1.5",
	        "legendshadow": "0",
	        "legendborderalpha": "30",
	        "canvasborderalpha": "50",
	        "numvdivlines": "5",
	        "vdivlinealpha": "20",
	        "showborder": "1",
	        "anchorRadius": "6",
            "anchorBorderThickness": "2",
	        "yAxisMinValue": "0",
            "yAxisMaxValue": "100"

	    },
	    "categories": [
	        {
	            "category": [';
	            	$count = count($months);
	            	foreach ($months as $month) {
	    				$chart.= '{ "label": "'.$month->label." ".$month->annum;
	    				if($count==1)
	    					$chart.='" }';
	    				else
	    					$chart.='" },';
	    				$count--;
		            }
	            $chart.=']
	        }
	    ],
	    "dataset": [';
	    	$counts = count($test_types);
	    	foreach ($test_types as $test_type) {
        		$chart.= '{
        			"seriesname": "'.$test_type->name.'",
        			"data": [';
        				$counter = count($months);
            			foreach ($months as $month) {
            			$data = self::getPrevalenceCountsByTestType($month, $test_type->id);
            			foreach ($data as $datum) {
            				$chart.= '{"value": "'.$datum->rate;
            				if($counter==1)
            					$chart.='"}';
            				else
            					$chart.='"},';
	            		}

	            		if($data->isEmpty())
            			{
            				$chart.= '{ "value": "0.00';
            				if($counter==1)
            					$chart.='"}';
            				else
            					$chart.='"},';
            			}
            			$counter--;
			    	}
		    	$chart.=']';
		    	if($counts==1)
					$chart.='}';
				else
					$chart.='},';
				$counts--;
		    }
           $chart.='
	    	]
	    }';
	return $chart;
	}
	/**
	 * Function to return prevalence counts by dates
	 */
	public static function getPrevalenceCounts($from, $to){
		$data =  Test::select(DB::raw('test_types.id as id, test_types.name as test, count(tests.specimen_id) as total, 
					SUM(IF(test_results.result=\'Positive\',1,0)) positive, SUM(IF(test_results.result=\'Negative\',1,0)) negative,
					ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'))
					->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
					->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
					->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
					->join('test_results', 'tests.id', '=', 'test_results.test_id')
					->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
					->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
					->whereBetween('time_created', array($from, $to))
					->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
					->groupBy('test_types.id')
					->get();
		return $data;
	}
	/**
	 * Function to return counts by month and test type
	 */
	public static function getPrevalenceCountsByTestType($month, $test_type){
		$data =  Test::select(DB::raw('ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'))
					->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
					->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
					->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
					->join('test_results', 'tests.id', '=', 'test_results.test_id')
					->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
					->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
					->where('test_types.id', '=', $test_type)
					->whereRaw('MONTH(time_created) = '.$month->months)
					->whereRaw('YEAR(time_created) = '.$month->annum)
					->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
					->groupBy('test_types.id')
					->get();
		return $data;
	}
	/**
	 * Function to filter prevalence rates by dates
	 */
	public static function filterPrevalenceRates()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		
		$months = self::getMonths($from, $to);
		$data = self::getPrevalenceCounts($from, $to);
		$chart = self::getPrevalenceRatesChart();
		return Response::json(array('values'=>$data, 'chart'=>$chart));
		//array('values'=>$data, 'chart'=>$chart)
	}
}
