<?php

class DailyLogController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$date = date('Y-m-d');
		$labsections = TestCategory::lists('name', 'id');
		$testtypes = TestType::all();
		$tests = Test::where('time_created', 'LIKE', $date.'%')->get();
		$visits = Visit::where('created_at', 'LIKE', $date.'%')->get();
		$specimens = Specimen::where('time_rejected', 'LIKE', $date.'%')->get();
		return View::make('reports.daily.index')
					->with('labsections', $labsections)
					->with('testtypes', $testtypes)
					->with('tests', $tests)
					->with('visits', $visits)
					->with('specimens', $specimen);
	}

	public function dailyLogs(){
		$date_from;
		$date_to;
		$lab_section;
		$test_type;
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
	 * Show the form for searching the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function search($id)
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
	* Function to select lists based on one another e.g. test types based on lab section
	*/
	public function loadDropdown(){
		$input = Input::get('option');
	    $category = TestCategory::find($input);
	    $test_types = $category->testTypes();
	    return $test_types->get(['id','name']);
	}


}
