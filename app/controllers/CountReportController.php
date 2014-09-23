<?php

class CountReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$test_types = TestType::all();
		$specimen_types = SpecimenType::all();
		return View::make('reports.counts.index')
					->with('test_types', $test_types)
					->with('specimen_types', $specimen_types);
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
	 * Functions for ungrouped test counts.
	 *
	 */
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
	/**
	 * Functions for ungrouped specimen counts.
	 *
	 */
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


}
