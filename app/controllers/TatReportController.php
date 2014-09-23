<?php

class TatReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('reports.tat.index');
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
	public function store()
	{
		//
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

	/**
	 * Function to return target turnaround time
	 *
	 */
	public static function targetTurnAroundTime($id)
	{
		return TestType::select(DB::raw('targetTAT'))
                     ->where('id', '=', $id)
                     ->get();
	}

	/**
	 * Function to return waiting time
	 *
	 */
	public static function waitingTime($id)
	{
		$total_test_count = Test::select(DB::raw(' COUNT( id ), GROUP BY test_type_id'))
                     	->where('test_type_id', '=', $id)
        				->get();
        $tests = Test::where('test_type_id', '=', $id);
        $total_waiting_time = 0.00;
        foreach ($tests as $key => $test) {
        	$waiting_time = $test->time_started - $test->specimen->time_accepted;
        	$total_waiting_time+=$waiting_time;
        }
        return $total_waiting_time/$total_test_count;
	}

	/**
	 * Function to return actual turnaround time
	 *
	 */
	public static function actualTurnAroundTime($id)
	{
		$total_test_count = Test::select(DB::raw(' COUNT( id ), GROUP BY test_type_id'))
                     	->where('test_type_id', '=', $id)
        				->get();
        $tests = Test::where('test_type_id', '=', $id);
        $total_actual_tat = 0.00;
        foreach ($tests as $key => $test) {
        	$actual_tat = $test->time_completed - $test->time_started;
        	$total_actual_tat+=$actual_tat;
        }
        return $total_actual_tat/$total_test_count;
	}

}
