<?php

class PrevalenceRatesReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$labsections = TestCategory::all();
		$test_types = TestType::join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
            				 ->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
            				 ->where('measure_range', 'LIKE', '%Positive/Negative%')
            				 ->get();
		return View::make('reports.prevalence.index')
					->with('labsections', $labsections)
					->with('test_types', $test_types);
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
	 * Function to count total specimens by test type given.
	 *
	 */
	public static function totalSpecimens($id)
	{
		return Test::select(DB::raw(' COUNT( specimen_id ), GROUP BY test_type_id'))
                     	->where('test_type_id', '=', $id)
        				->get();
	}

	/**
	 * Function to count total positive specimens by test type given.
	 *
	 */
	public static function totalPositiveSpecimens($id)
	{
		return TestResult::join('tests', 'tests.id', '=', 'test_results.test_id')
            ->where('test_measures.result', '=', 'Positive')
            ->where('tests.test_type_id', '=', $id)
            ->count();
	}
	/**
	 * Function to count negative positive specimens by test type given.
	 *
	 */
	public static function totalNegativeSpecimens($id)
	{
		return $negative = totalSpecimens($id) - totalPositiveSpecimens($id);
	}
	/**
	 * Function to compute the prevalence rate per test type.
	 *
	 */
	public static function prevalenceRate($id)
	{
		$total = totalSpecimens($id);
		$positive = totalPositiveSpecimens($id);
		$prevalence = ($positive/$total)*100;
		return round($prevalence, 2);
	}


}
