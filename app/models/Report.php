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
	               'm'=>'month',
	               'd'=>'day',
	               'h'=>'hour',
	               'i'=>'minute',
	               's'=>'second');
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

	/*
	*	End prevalence rates functions
	*/

	/*
	*	Begin counts functions
	*/

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