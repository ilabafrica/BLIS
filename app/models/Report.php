<?php
class Report{
	/*
	*	Begin report settings functions
	*/

	/*
	*	End report settings functions
	*/

	/*
	*	Begin patient report functions
	*/

	#	Begin function to export to word
	#	End function to export to pdf

	/*
	*	End patient report functions
	*/

	/*
	*	Begin daily log functions
	*/

	#	Begin function to count total tests by lab section
	public static function logTestsByLabSection($id){
		return Test::select('tests.id')
					->join('test_types','tests.test_type_id', '=', 'test_types.id')
					->join('test_categories', 'test_types.section_id', '=', 'test_categories.id')
					->where('test_categories.name', '=', $id)
					->count();
	}
	#	End function to count total tests by lab section

	#	Begin function to get distinct patient gender
	public static function getPatientsGender(){
		return Patient::select(DB::raw('DISTINCT gender as sex'))
					->get();
	}
	#	End function to get distinct patient gender

	#	Begin function to count total patients by gender
	public static function logPatientsByGender($id){
		return Visit::select('visits.id')
					->join('patients','visits.patient_id', '=', 'patients.id')
					->where('patients.gender', '=', $id)
					->count();
	}
	#	End function to count total total patients by gender
	/*
	*	End daily log functions
	*/

	/*
	*	Begin prevalence rates functions
	*/

	#	Begin function to get total specimens by test type
	public static function totalSpecimen($id){
		return Test::select('specimen_id')
						->where('test_type_id', '=', $id)
        				->count();
	}
	#	End function to get total, positive, negative specimen by test type

	#	Begin function to get positive specimens by test type
	public static function positiveSpecimen($id){
		return TestResult::join('tests', 'tests.id', '=', 'test_results.test_id')
			            ->where('test_results.result', '=', 'Positive')
			            ->where('tests.test_type_id', '=', $id)
			            ->count();
	}
	#	End function to get total, positive, negative specimen by test type

	#	Begin function to get negative specimens by test type
	public static function negativeSpecimen($id){
		return self::totalSpecimen($id) - self::positiveSpecimen($id);
	}
	#	End function to get total, positive, negative specimen by test type

	#	Begin function to load months initially
	public static function loadMonths($year){
		$months = Test::select(DB::raw('MIN(time_created) as start, MAX(time_created) as end'))
							->whereRaw('YEAR(time_created) = '.$year)
							->get();
		return $months;
	}
	#	End function to load months

	#	Begin function to return months for time_created column
	public static function getMonths($from, $to){
		$dates = Test::select(DB::raw('DISTINCT MONTH(time_created) as months, LEFT(MONTHNAME(time_created), 3) as label, YEAR(time_created) as annum'));
		if($from==$to){
			$year = date('Y');
			$dates->whereRaw('YEAR(time_created) = '.$year);
		}
		else{
			$dates->whereBetween('time_created', array($from, $to));
			}
		return $dates->orderBy('time_created', 'ASC')->get();
	}
	#	End function to return months for time_created
	#Begin function to return test_type_id, test_type_name, total specimen tested, positive and negative counts
	public static function prevalenceCounts($from, $to){
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
	#End function to return counts
	#	Begin function to return counts by month and test type
	public static function prevalenceCountsByTestType($month, $test_type){
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
	#	End function to return counts by month and test type
	/*
	*	End prevalence rates functions
	*/

	/*
	*	Begin counts functions
	*/
	#	Begin function to return pending tests
	public static function PendingTestCount($test_type_id)
	{
		$count_pending = Test::whereIn('test_status_id', function($query) use ($test_type_id){
									    $query->select('id')
									    ->from(with(new TestStatus)->getTable())
									    ->whereIn('name', ['Pending', 'Started'])
									    ->where('test_type_id', $test_type_id);
									})->count();
		return $count_pending;
	}
	#	End function to return pending tests

	#	Begin function to return completed tests
	public static function CompletedTestCount($test_type_id)
	{
		$count_completed = Test::whereIn('test_status_id', function($query)  use ($test_type_id){
								    $query->select('id')
								    ->from(with(new TestStatus)->getTable())
								    ->whereIn('name', ['Completed', 'Verified'])
								    ->where('test_type_id', $test_type_id);
								})->count();
		return $count_completed;
	}
	#	End function to return completed tests

	#	Begin function to return accepted specimen ungrouped
	public static function AcceptedSpecimenCount($specimen_type_id)
	{
		$count_accepted = Specimen::whereIn('specimen_status_id', function($query) use ($specimen_type_id){
									    $query->select('id')
									    ->from(with(new SpecimenStatus)->getTable())
									    ->whereIn('name', ['Accepted'])
									    ->where('specimen_type_id', $specimen_type_id);
									})->count();
		return $count_accepted;
	}
	#	End function to return accepted specimen ungrouped

	#	Begin function to return rejected specimen ungrouped
	public static function RejectedSpecimenCount($specimen_type_id)
	{
		$count_rejected = Specimen::whereIn('specimen_status_id', function($query) use ($specimen_type_id){
									    $query->select('id')
									    ->from(with(new SpecimenStatus)->getTable())
									    ->whereIn('name', ['Rejected'])
									    ->where('specimen_type_id', $specimen_type_id);
									})->count();
		return $count_rejected;
	}
	#	End function to return rejected specimen ungrouped

	#	Begin function to export to word
	#	End function to export to pdf

	/*
	*	End counts functions
	*/

	/*
	*	Begin turnaround time functions
	*/

	#	Begin function to return waiting time
	public static function waitingTime($id)
	{
		$total_test_count = Test::where('test_type_id', '=', $id)
        				->count();
        $tests = Test::where('test_type_id', '=', $id)->get();
        $cumulative_diff = 0.00;
        foreach ($tests as $test) {
        	$date_diff = strtotime($test->time_started) - strtotime($test->specimen->time_accepted);
			$hours_diff = floor($date_diff/(60*60));
			
			$cumulative_diff += $hours_diff;
        }
        return round($cumulative_diff/$total_test_count, 2);
	}
	#	End function to return waiting time
	#	Begin function to return actual time
	public static function actualTurnAroundTime($id)
	{
		$total_test_count = Test::where('test_type_id', '=', $id)
        				->count();
        $tests = Test::where('test_type_id', '=', $id)->get();
        $cumulative_diff = 0.00;
        foreach ($tests as $key => $test) {
        	$date_diff = strtotime($test->time_completed) - strtotime($test->time_started);
        	$hours_diff = floor($date_diff/(60*60));
        	$cumulative_diff += $hours_diff;
        }
        return round($cumulative_diff/$total_test_count, 2);
	}
	#	End function to return actual time
	
	#	Begin function to return total waiting time
	public static function totalWaitingTime()
	{
		$tests = Test::all();
        $cumulative_diff = 0.00;
        foreach ($tests as $test) {
        	$date_diff = strtotime($test->time_started) - strtotime($test->specimen->time_accepted);
			$hours_diff = floor($date_diff/(60*60));
			
			$cumulative_diff += $hours_diff;
        }
        return round($cumulative_diff/count($tests), 2);
	}
	#	End function to return total waiting time
	#	Begin function to return total actual time
	public static function totalActualTurnAroundTime()
	{
		$tests = Test::all();
        $cumulative_diff = 0.00;
        foreach ($tests as $key => $test) {
        	$date_diff = strtotime($test->time_completed) - strtotime($test->time_started);
        	$hours_diff = floor($date_diff/(60*60));
        	$cumulative_diff += $hours_diff;
        }
        return round($cumulative_diff/count($tests), 2);
	}
	#	End function to return total actual time
	#	Begin function to return expected TAT for all test types
	public static function totalExpectedTurnAroundTime()
	{
		$test_types = TestType::all();
        $cumulative_diff = 0.00;
        foreach ($test_types as $test_type) {
        	$cumulative_diff += $test_type->targetTAT;
        }
        return round($cumulative_diff/count($test_types), 2);
	}
	#	End function to return expected TAT for all test types

	#	Begin function to return expected TAT for all test types in a lab section 
	public static function expectedTurnAroundTime($id)
	{
		$tests = Test::all();
        $cumulative_diff = 0.00;
        foreach ($tests as $key => $test) {
        	$date_diff = strtotime($test->time_completed) - strtotime($test->time_started);
        	$hours_diff = floor($date_diff/(60*60));
        	$cumulative_diff += $hours_diff;
        }
        return round($cumulative_diff/count($tests), 2);
	}
	#	End function to return expected TAT for all test types in a lab section 
	
	/*
	*	End turnaround time functions
	*/

	/*
	*	Begin infection report functions
	*/

	/*
	*	End infection report functions
	*/

	/*
	*	Begin user statistics functions
	*/

	/*
	*	End user statistics functions
	*/
}