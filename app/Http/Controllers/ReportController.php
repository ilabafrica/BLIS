<?php namespace App\Http\Controllers;
set_time_limit(0); //60 seconds = 1 minute

use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use App\Http\Controllers\Controller;


use App\Models\User;
use App\Models\Test;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Disease;
use App\Models\Control;
use App\Models\Measure;
use App\Models\Receipt;
use App\Models\Specimen;
use App\Models\TestType;
use App\Models\TestResult;
use App\Models\ControlTest;
use App\Models\SpecimenType;
use App\Models\TestCategory;
use App\Models\ReportDisease;
use App\Models\TestTypeMeasure;

use Input;
use Response;
use Config;
use DateTime;
use Session;
use DB;
use Lang;
use Jenssegers\Date\Date as Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadPatients()
    {
        $search = Input::get('search');

        $patients = Patient::search($search)->orderBy('id','DESC')->paginate(Config::get('blis.page-items'));

        if (count($patients) == 0) {
            Session::flash('message', trans('messages.no-match'));
        }

        // Load the view and pass the patients
        return view('report.daily.patient.index', compact('patients'))->withInput(Input::all());
    }

    /**
     * Display data after applying the filters on the report uses patient ID
     *
     * @return Response
     */
    public function viewPatientReport($id, $visit = null){
        $from = Carbon::parse(Input::get('from'));
        $to = Carbon::parse(Input::get('to'));
        $pending = Input::get('pending');
        $date = Carbon::today();
        $error = '';
        $visitId = Input::get('visit_id');
        //  Check checkbox if checked and assign the 'checked' value
        if (Input::get('tests') === '1') {
            $pending='checked';
        }
        //  Query to get tests of a particular patient
        if(($visit || $visitId) && $id){
            $tests = Test::where('visit_id', '=', $visit?$visit:$visitId);
        }
        else{
            $tests = Test::join('visits', 'visits.id', '=', 'tests.visit_id')
                            ->where('patient_id', '=', $id);
        }
        //  Begin filters - include/exclude pending tests
        if($pending){
            $tests=$tests->where('tests.test_status_id', '!=', Test::NOT_RECEIVED);
        }
        else{
            $tests = $tests->whereIn('tests.test_status_id', [Test::COMPLETED, Test::VERIFIED]);
        }
        //  Date filters
        if($from||$to){

            if(!$to) $to = $date;

            if($from->gt($to) || $from->gt($date) || $to->gt($date)){
                    $error = trans('terms.check-date-range');
            }
            else
            {
                $toPlusOne = $to->addDay();
                $tests=$tests->whereBetween('time_created', [$from->toDateTimeString(), $toPlusOne->toDateTimeString()]);
            }
        }
        //  Get tests collection
        $tests = $tests->get(array('tests.*'));
        //  Get patient details
        $patient = Patient::find($id);
        //  Check if tests are accredited
        $accredited = array();
        $verified = array();
        foreach ($tests as $test)
        {
            if($test->testType->isAccredited())
                array_push($accredited, $test->id);
            else
                continue;
        }
        foreach ($tests as $test)
        {
            if($test->isVerified())
                array_push($verified, $test->id);
            else
                continue;
        }
        if(Input::has('word'))
        {
            $date = date("Ymdhi");
            $fileName = "blispatient_".$id."_".$date.".doc";
            $headers = array(
                "Content-type"=>"text/html",
                "Content-Disposition"=>"attachment;Filename=".$fileName
            );
            $content = view('report.daily.patient.export', compact('patient', 'tests', 'from', 'to', 'visit', 'accredited'));
            return Response::make($content, 200, $headers);
        }
        else
        {
            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.daily.patient.report', compact('patient', 'tests', 'pending', 'error', 'visit', 'accredited', 'verified', 'from', 'to'))->withInput(Input::all());
        }
    }

    //  Begin Daily Log-Patient report functions
    /**
     * Display a view of the daily patient records.
     *
     */
    public function log()
    {
        $start = Carbon::parse(Input::get('from'));
        $end = Carbon::parse(Input::get('to'));
        $date = Carbon::today();
        $today = clone $date;
        $completePending = Input::get('completePending');
        $error = '';
        $from = Carbon::parse($start->toDateString());
        $to = Carbon::parse($end->toDateString());
        $accredited = array();
        //  Check radiobutton for pending/all tests is checked and assign the 'true' value
        if (Input::get('tests') === '1') {
            $pending='true';
        }
        if(!$to){
            $to=$date;
        }
        $added = clone $to;
        $toPlusOne = $added->addDay();
        $records = Input::get('records');
        if(!$records)
            $records = trans('menu.test-records');
        $testCategory = Input::get('test_category_id');
        $testType = Input::get('test_type_id');
        $labSections = TestCategory::lists('name', 'id');
        if($testCategory)
            $testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
        else
            $testTypes = array(""=>"");
        if($records==trans('menu.patient-records'))
        {
            if($from||$to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('terms.check-date-range');
                }
                else{
                    $visits = Visit::whereBetween('created_at', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
                if (count($visits) == 0) {
                    Session::flash('message', trans('messages.no-match'));
                }
            }
            else
            {

                $visits = Visit::where('created_at', 'LIKE', $date.'%')->orderBy('patient_id');
            }
            $visits = $visits->get();
            if(Input::has('word'))
            {
                $date = date("Ymdhi");
                $fileName = "daily_visits_log_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportPatientLog', compact('visits', 'accredited'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.patient', compact('visits', 'error', 'accredited', 'from', 'to', 'records', 'completePending', 'labSections'))->withInput(Input::all());
            }
        }
        //Begin specimen rejections
        else if($records==trans('menu.specimen-rej-rec'))
        {
            $specimens = Specimen::where('specimen_status_id', '=', Specimen::REJECTED);
            /*Filter by test category*/
            if($testCategory || $testType)
            {
                $ids = TestCategory::find($testCategory)->testTypes->lists('id');
                if($testType)
                {
                    $specimens = $specimens->whereIn('specimen_type_id', DB::table('testtype_specimentypes')->where('test_type_id', $testType)->lists('specimen_type_id'));
                }
                else
                {
                    $specimens = $specimens->whereIn('specimen_type_id', DB::table('testtype_specimentypes')->whereIn('test_type_id', $ids)->lists('specimen_type_id'));
                }
            }
            /*Filter by date*/
            if($from||$to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('terms.check-date-range');
                }
                else
                {
                    $specimens = $specimens->whereBetween('time_rejected', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
            }
            else
            {
                $specimens = $specimens->where('time_rejected', 'LIKE', $date.'%')->orderBy('id');
            }
            $specimens = $specimens->get();
            if(Input::has('word')){
                $date = date("Ymdhi");
                $fileName = "daily_rejected_specimen_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportSpecimenLog', compact('specimens', 'testCategory', 'testType', 'accredited', 'from', 'to', 'completePending', 'labSections'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.specimen', compact('labSections', 'testType', 'specimens', 'testCategory', 'error', 'accredited', 'from', 'to', 'records', 'completePending'))->withInput(Input::all());
            }
        }
        //Begin test records
        else
        {
            $tests = Test::whereNotIn('test_status_id', [Test::NOT_RECEIVED]);
            
            /*Filter by test category*/
            if($testCategory || $testType)
            {
                $ids = TestCategory::find($testCategory)->testTypes->lists('id');
                if($testType)
                {
                    $tests = $tests->whereIn('test_type_id', $ids);
                }
                else
                {
                    $tests = $tests->where('test_type_id', '=', $testType);
                }
            }
            /*Filter by all tests*/
            if($completePending==trans('menu.complete'))
            {
                $tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
            }
            /*Get collection of tests*/
            /*Filter by date*/
            if($from || $to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('terms.check-date-range');
                }
                else
                {
                    $tests = $tests->whereBetween('time_created', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
            }
            else
            {
                $tests = $tests->where('time_created', 'LIKE', $date->toDateString().'%');
            }

            $tests = $tests->get();
            if(Input::has('word')){
                $date = date("Ymdhi");
                $fileName = "daily_test_records_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportTestLog', compact('tests', 'testCategory', 'testType', 'completePending', 'accredited'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.test', compact('labSections', 'testTypes', 'tests', 'counts', 'testCategory', 'testType', 'completePending', 'accredited', 'error', 'from', 'to', 'records'))->withInput(Input::all());
            }
        }
    }
    //  Begin count reports functions
    /**
     * Display a test((un)grouped) and specimen((un)grouped) counts.
     *
     */
    public function count()
    {
        $start = Carbon::parse(Input::get('from'));
        $end = Carbon::parse(Input::get('to'));
        $date = Carbon::today();
        $today = clone $date;
        $error = '';
        $from = Carbon::parse($start->toDateString());
        $to = Carbon::parse($end->toDateString());
        $to_date = clone $to;
        $toPlusOne = $to_date->addDay();
        $counts = Input::get('counts');
        if(!$counts)
            $counts = trans('menu.ungrouped-test');
        $accredited = array();
        //  Begin grouped test counts
        if($counts==trans('menu.grouped-test'))
        {
            $testCategories = TestCategory::all();
            $testTypes = TestType::all();
            $ageRanges = array('0-5', '5-15', '15-120');    //  Age ranges - will definitely change in configurations
            $gender = array(Patient::MALE, Patient::FEMALE);    //  Array for gender - male/female

            $perAgeRange = array(); // array for counts data for each test type and age range
            $perTestType = array(); //  array for counts data per testype
            if($from->gt($to) || $from->gt($date) || $to->gt($date))
            {
                Session::flash('message', trans('terms.check-date-range'));
            }
            foreach ($testTypes as $testType)
            {
                $countAll = $testType->groupedTestCount(null, null, $from->toDateString(), $toPlusOne->toDateString());
                $countMale = $testType->groupedTestCount([Patient::MALE], null, $from->toDateString(), $toPlusOne->toDateString());
                $countFemale = $testType->groupedTestCount([Patient::FEMALE], null, $from->toDateString(), $toPlusOne->toDateString());
                $perTestType[$testType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
                foreach ($ageRanges as $ageRange)
                {
                    $maleCount = $testType->groupedTestCount([Patient::MALE], $ageRange, $from->toDateString(), $toPlusOne->toDateString());
                    $femaleCount = $testType->groupedTestCount([Patient::FEMALE], $ageRange, $from->toDateString(), $toPlusOne->toDateString());
                    $perAgeRange[$testType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
                }
            }
            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.aggregate.count.groupedTest', compact('testCategories', 'ageRanges', 'gender', 'perTestType', 'perAgeRange', 'counts', 'accredited', 'from', 'to'))->withInput(Input::all());
        }
        else if($counts==trans('menu.ungrouped-specimen'))
        {
            if($from->gt($to) || $from->gt($date) || $to->gt($date))
            {
                Session::flash('message', trans('terms.check-date-range'));
            }

            $ungroupedSpecimen = array();
            foreach (SpecimenType::all() as $specimenType)
            {
                $rejected = $specimenType->countPerStatus([Specimen::REJECTED], $from->toDateString(), $toPlusOne->toDateString());
                $accepted = $specimenType->countPerStatus([Specimen::ACCEPTED], $from->toDateString(), $toPlusOne->toDateString());
                $total = $rejected+$accepted;
                $ungroupedSpecimen[$specimenType->id] = ["total"=>$total, "rejected"=>$rejected, "accepted"=>$accepted];
            }

            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.aggregate.count.ungroupedSpecimen', compact('ungroupedSpecimen', 'counts', 'accredited', 'from', 'to'))->withInput(Input::all());

        }
        else if($counts==trans('menu.grouped-specimen'))
        {
            $ageRanges = array('0-5', '5-15', '15-120');    //  Age ranges - will definitely change in configurations
            $gender = array(Patient::MALE, Patient::FEMALE);    //  Array for gender - male/female

            $perAgeRange = array(); // array for counts data for each test type and age range
            $perSpecimenType = array(); //  array for counts data per testype
            if($from->gt($to) || $from->gt($date) || $to->gt($date))
            {
                Session::flash('message', trans('terms.check-date-range'));
            }
            $specimenTypes = SpecimenType::all();
            foreach ($specimenTypes as $specimenType)
            {
                $countAll = $specimenType->groupedSpecimenCount([Patient::MALE, Patient::FEMALE], null, $from->toDateString(), $toPlusOne->toDateString());
                $countMale = $specimenType->groupedSpecimenCount([Patient::MALE], null, $from->toDateString(), $toPlusOne->toDateString());
                $countFemale = $specimenType->groupedSpecimenCount([Patient::FEMALE], null, $from->toDateString(), $toPlusOne->toDateString());
                $perSpecimenType[$specimenType->id] = ['countAll'=>$countAll, 'countMale'=>$countMale, 'countFemale'=>$countFemale];
                foreach ($ageRanges as $ageRange)
                {
                    $maleCount = $specimenType->groupedSpecimenCount([Patient::MALE], $ageRange, $from->toDateString(), $toPlusOne->toDateString());
                    $femaleCount = $specimenType->groupedSpecimenCount([Patient::FEMALE], $ageRange, $from->toDateString(), $toPlusOne->toDateString());
                    $perAgeRange[$specimenType->id][$ageRange] = ['male'=>$maleCount, 'female'=>$femaleCount];
                }
            }
            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.aggregate.count.groupedSpecimen', compact('specimenTypes', 'counts', 'ageRanges', 'gender', 'perSpecimenType', 'perAgeRange', 'accredited', 'from', 'to'))->withInput(Input::all());
        }
        else
        {
            if($from->gt($to) || $from->gt($date) || $to->gt($date))
            {
                Session::flash('message', trans('terms.check-date-range'));
            }

            $ungroupedTests = array();
            foreach (TestType::all() as $testType)
            {
                $pending = $testType->countPerStatus([Test::PENDING, Test::STARTED], $from->toDateString(), $toPlusOne->toDateString());
                $complete = $testType->countPerStatus([Test::COMPLETED, Test::VERIFIED], $from->toDateString(), $toPlusOne->toDateString());
                $ungroupedTests[$testType->id] = ["complete"=>$complete, "pending"=>$pending];
            }

            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.aggregate.count.ungroupedTest', compact('ungroupedTests', 'counts', 'accredited', 'from', 'to'))->withInput(Input::all());
        }
    }

    /**
    *   Function to return test types of a particular test category to fill test types dropdown
    */
    public function dropdown()
    {
        $input = Input::get('test_category_id');
        $testCategory = TestCategory::find($input);
        return json_encode($testCategory->testTypes);
    }

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

		return view('reports.prevalence.index')
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
		return view('reports.tat.index')
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
		
		return view('reports.infection.index')
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
		
		return view('reports.userstatistics.index')
					->with('reportTypes', $reportTypes)
					->with('reportData', $reportData)
					->with('reportTitle', $reportTitle)
					->with('selectedReport', $selectedReport)
					->withInput(Input::all());
	}

	/**
	* Returns qc index page
	*
	* @return view
	*/
	public function qualityControl()
	{
		$controls = Control::all()->lists('name', 'id');
		$accredited = array();
		$tests = array();
		return view('reports.qualitycontrol.index')
			->with('accredited', $accredited)
			->with('tests', $tests)
			->with('controls', $controls);
	}

	/**
	* Returns qc results for a specific control page
	*
	* @param Input - controlId, date range
	* @return view
	*/
	public function qualityControlResults()
	{
		$rules = array('start_date' => 'date|required',
					'end_date' => 'date|required',
					'control' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::back()->withErrors($validator)->withInput();
		}
		else {
			$controlId = Input::get('control');
			$endDatePlusOne = date_add(new DateTime(Input::get('end_date')), date_interval_create_from_date_string('1 day'));
			$dates= array(Input::get('start_date'), $endDatePlusOne);
			$control = Control::find($controlId);
			$controlTests = ControlTest::where('control_id', '=', $controlId)
										->whereBetween('created_at', $dates)->get();
			$leveyJennings = $this->leveyJennings($control, $dates);
			return view('reports.qualitycontrol.results')
				->with('control', $control)
				->with('controlTests', $controlTests)
				->with('leveyJennings', $leveyJennings)
				->withInput(Input::all());
		}
	}

	/**
	 * Displays Surveillance
	 * @param string $from, string $to, array() $testTypeIds
	 * As of now surveillance works only with alphanumeric measures
	 */
	public function surveillance(){
		/*surveillance diseases*/
		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');
		$to = Input::get('end');
		if(!$to) $to = $date;

		$surveillance = Test::getSurveillanceData($from, $to.' 23:59:59');
		$accredited = array();
		$tests = array();
		$testTypes = TestType::all();
		if(Input::has('word')){
			$fileName = "surveillance_".$date.".doc";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$fileName
			);
			$content = view('reports.surveillance.exportSurveillance')
							->with('surveillance', $surveillance)
							->with('tests', $tests)
							->with('accredited', $accredited)
							->withInput(Input::all());
			return Response::make($content,200, $headers);
		}else{
			return view('reports.surveillance.index')
					->with('accredited', $accredited)
					->with('tests', $tests)
					->with('surveillance', $surveillance)
					->with('testTypes', $testTypes)
					->withInput(Input::all());
		}
	}

	/**
	 * Manage Surveillance Configurations
	 * @param
	 */
	public function surveillanceConfig(ReportRequest $request){
// dd('surveillanceConfig');
// dd($request->all());
        $allSurveillanceIds = array();
		
        //edit or leave surveillance entries as is
        if ($request->surveillance) {
            $diseases = $request->surveillance;

        // dd($request->all());
			foreach ($diseases as $id => $disease) {
                $allSurveillanceIds[] = $id;
				$surveillance = ReportDisease::find($id);
				$surveillance->test_type_id = $disease['test_type'];
				$surveillance->disease_id = $disease['disease'];
				$surveillance->save();
			}
		}
		
		//save new surveillance entries
		if ($request->new_surveillance) {
			$diseases = $request->new_surveillance;

			foreach ($diseases as $id => $disease) {
				$surveillance = new ReportDisease;
				$surveillance->test_type_id = $disease['test_type'];
				$surveillance->disease_id = $disease['disease'];
				$surveillance->save();
                $allSurveillanceIds[] = $surveillance->id;
				
			}
		}

        //check if action is from a form submission
        if ($request->fromForm) {
	     	// Delete any pre-existing surveillance entries
	     	//that were not captured in any of the above save loops
	        $allSurveillances = ReportDisease::all(array('id'));

	        $deleteSurveillances = array();

	        //Identify survillance entries to be deleted by Ids
	        foreach ($allSurveillances as $key => $value) {
	            if (!in_array($value->id, $allSurveillanceIds)) {
	                $deleteSurveillances[] = $value->id;
	            }
	        }
	        //Delete Surveillance entry if any
	        if(count($deleteSurveillances)>0)ReportDisease::destroy($deleteSurveillances);
        }

		$diseaseTests = ReportDisease::all();
		$diseases = Disease::all();
		$testTypes = TestType::all();

		return view('reportconfig.surveillance')
					->with('testTypes', $testTypes)
					->with('diseases', $diseases)
					->with('diseaseTests', $diseaseTests);
	}

	/**
	 * Manage Diseases reported on
	 * @param
	 */
	// todo: using $request quite problematic not sure how
    public function disease(ReportRequest $request){
        dd($request->all());
		if ($request) {
			$rules = array();

			$newDiseases = $request->newDiseases;

			/*if ($request->newDiseases) {
				// create an array that form the rules array
				foreach ($newDiseases as $key => $value) {
					
					//Ensure no duplicate disease
					$rules['newDiseases.'.$key.'.disease'] = 'unique:diseases,name';
				}
			}*/

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				return redirect()->to('reportconfig.disease')->withErrors($validator);
			} else {

		        $allDiseaseIds = array();
				
				//edit or leave disease entries as is
				if ($request->diseases) {
					$diseases = $request->diseases;

					foreach ($diseases as $id => $disease) {
		                $allDiseaseIds[] = $id;
						$diseases = Disease::find($id);
						$diseases->name = $disease['disease'];
						$diseases->save();
					}
				}
				
				//save new disease entries
				if ($request->newDiseases) {
					$diseases = $request->newDiseases;

					foreach ($diseases as $id => $disease) {
						$diseases = new Disease;
						$diseases->name = $disease['disease'];
						$diseases->save();
		                $allDiseaseIds[] = $diseases->id;
					}
				}

		        //check if action is from a form submission
		        if ($request->fromForm) {
			     	// Delete any pre-existing disease entries
			     	//that were not captured in any of the above save loops
			        $allDiseases = Disease::all(array('id'));

			        $deleteDiseases = array();

			        //Identify disease entries to be deleted by Ids
			        foreach ($allDiseases as $key => $value) {
			            if (!in_array($value->id, $allDiseaseIds)) {

							//Allow delete if not in use
							$inUseByReports = Disease::find($value->id)->reportDiseases->toArray();
							if (empty($inUseByReports)) {
							    
							    // The disease is not in use
			                	$deleteDiseases[] = $value->id;
							}
			            }
			        }
			        //Delete disease entry if any
			        if(count($deleteDiseases)>0){

			        	Disease::destroy($deleteDiseases);
			        }
		        }
			}
		}
		$diseases = Disease::all();

		return view('reportconfig.disease')
					->with('diseases', $diseases);
	}

	public function stockLevel(){
		
		//	Fetch form filters
		$date = date('Y-m-d');
		$from = Input::get('start');
		if(!$from) $from = date('Y-m-01');

		$to = Input::get('end');
		if(!$to) $to = $date;
		
		$reportTypes = array('Monthly', 'Quarterly');
		

		$selectedReport = Input::get('report_type');	
		if(!$selectedReport)$selectedReport = 0;

		switch ($selectedReport) {
			case '0':
			
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.monthly-stock-level-report-title',1);
				break;
			case '1':
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.quarterly-stock-level-report-title',1);
				break;
				default:
				$reportData = Receipt::getIssuedCommodities($from, $to.' 23:59:59');
				$reportTitle = Lang::choice('messages.monthly-stock-level-report-title',1);
				break;
		}

		$reportTitle = str_replace("[FROM]", $from, $reportTitle);
		$reportTitle = str_replace("[TO]", $to, $reportTitle);
		
		return view('reports.inventory.index')
					->with('reportTypes', $reportTypes)
					->with('reportData', $reportData)
					->with('reportTitle', $reportTitle)
					->with('selectedReport', $selectedReport)
					->withInput(Input::all());
	}

	/**
	* Function to calculate the mean, SD, and UCL, LCL
	* for a given control measure.
	*
	* @param control_measure_id
	* @return json string
	* 
	*/
	public function leveyJennings($control, $dates)
	{
		foreach ($control->controlMeasures as $key => $controlMeasure) {
			if(!$controlMeasure->isNumeric())
			{
				//We ignore non-numeric results
				continue;
			}

			$results = $controlMeasure->results()->whereBetween('created_at', $dates)->lists('results');

			$count = count($results);

			if($count < 6)
			{
				$response[] = array('success' => false,
					'error' => "Too few results to create LJ for ".$controlMeasure->name);
				continue;
			}

			//Convert string results to float 
			foreach ($results as &$result) {
				$result = (double) $result;
			}

			$total = 0;
			foreach ($results as $res) {
				$total += $res;
			}

			$average = round($total / $count, 2);

			$standardDeviation = $this->stat_standard_deviation($results);
			$standardDeviation  = round($standardDeviation, 2);

			$response[] = array('success' => true,
							'total' => $total,
							'average' => $average,
							'standardDeviation' => $standardDeviation,
							'plusonesd' => $average + $standardDeviation,
							'plustwosd' => $average + ($standardDeviation * 2),
							'plusthreesd' => $average + ($standardDeviation * 3),
							'minusonesd' => $average - ($standardDeviation),
							'minustwosd' => $average - ($standardDeviation * 2),
							'minusthreesd' => $average - ($standardDeviation * 3),
							'dates' => $controlMeasure->results()->lists('created_at'),
							'controlName' => $controlMeasure->name,
							'controlUnit' => $controlMeasure->unit,
							'results' => $results);
		}
		return json_encode($response);
	}

    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     * 
     * @param array $a 
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stat_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
    /**
    *	Function to check for accredited test types
    *
    */
    public function accredited($tests)
    {
    	$accredited = array();
		foreach ($tests as $test) {
			if($test->testType->isAccredited())
				array_push($accredited, $test->id);
		}
		return $accredited;
    }
}
