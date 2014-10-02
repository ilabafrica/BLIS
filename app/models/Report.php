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

	#	Begin function to return age of patient given dob
	public static function dateDiff($end)
	{
		$today=date('Y-m-d H:i:s');
	   $return = array();
	   
	   try {
	      $start = new DateTime($today);
	      $end = new DateTime($end);
	      $form = $start->diff($end);
	   } catch (Exception $e){
	      return $e->getMessage();
	   }
	   
	   $display = array('y'=>'year',
	               'm'=>'month'/*,
	               'd'=>'day',
	               'h'=>'hour',
	               'i'=>'minute',
	               's'=>'second'*/);
	   foreach($display as $key => $value){
	      if($form->$key > 0){
	         $return[] = $form->$key.' '.($form->$key > 1 ? $value.'s' : $value);
	      }
	   }
	   
	   return implode($return, ', ');
	}
	#	End function to return age of patient given dob

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
        				->groupBy('test_type_id')
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

	#	Begin function to return months for time_created column
	public static function getMonths(){
		return $dates = Test::select(DB::raw('DISTINCT MONTH(time_created) as label'))
						->get();
	}
	#	End function to return months for time_created

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
		$total_test_count = Test::select('id')
                     	->where('test_type_id', '=', $id)
        				->get();
        $tests = Test::where('test_type_id', '=', $id);
        $total_waiting_time = 0.00;
        foreach ($tests as $key => $test) {
        	$waiting_time = date_diff($test->time_started, $test->specimen->time_accepted);
        	$total_waiting_time+=$waiting_time;
        }
        return $total_waiting_time;
	}
	#	End function to return waiting time
	#	Begin function to return actual time
	public static function actualTurnAroundTime($id)
	{
		$total_test_count = Test::select('id')
                     	->where('test_type_id', '=', $id)
        				->count();
        $tests = Test::where('test_type_id', '=', $id);
        $total_actual_tat = 0.00;
        foreach ($tests as $key => $test) {
        	$actual_tat = $test->time_completed - $test->time_started;
        	$total_actual_tat+=$actual_tat;
        }
        return $total_actual_tat/$total_test_count;
	}
	#	End function to return actual time
	
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