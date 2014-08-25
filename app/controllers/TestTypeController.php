<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing test types
 *
 */
class TestTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active testtypes
			$testtypes = TestType::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the testtypes
		return View::make('testtype.index')->with('testtypes', $testtypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$measures = Measure::all();
		$specimentypes = SpecimenType::all();
		$labsections = TestCategory::all();
		//Create TestType
		return View::make('testtype.create')
					->with('labsections', $labsections)
					->with('measures', $measures)
					->with('specimentypes', $specimentypes);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'name' => 'required|unique:test_types,name',
			'section_id' => 'required',
			'specimentypes' => 'required',
			'measures' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::route('testtype.create')->withErrors($validator);
		} else {
			// store 
			$testtype = new TestType;
			$testtype->name = Input::get('name');
			$testtype->description = Input::get('description');
			$testtype->section_id = Input::get('section_id');
			$testtype->targetTAT = Input::get('targetTAT');
			$testtype->prevalence_threshold = Input::get('prevalence_threshold');
			try{
				$testtype->save();

				$testtype->setMeasures(Input::get('measures'));
				$testtype->setSpecimenTypes(Input::get('specimentypes'));

				return Redirect::route('testtype.index')->with('message', 'Successfully created test type!');
			}catch(QueryException $e){
				Log::error($e);
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show a testtype
		$testtype = TestType::find($id);

		//Show the view and pass the $testtype to it
		return View::make('testtype.show')->with('testtype', $testtype);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the testtype
		$testtype = TestType::find($id);
		$measures = Measure::all();
		$specimentypes = SpecimenType::all();
		$labsections = TestCategory::all();

		//Open the Edit View and pass to it the $testtype
		return View::make('testtype.edit')
					->with('testtype', $testtype)
					->with('labsections', $labsections)
					->with('measures', $measures)
					->with('specimentypes', $specimentypes);
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
		$rules = array(
			'name' => 'required',
			'section_id' => 'required',
			'specimentypes' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$testtype = TestType::find($id);
			$testtype->name = Input::get('name');
			$testtype->description = Input::get('description');
			$testtype->section_id = Input::get('section_id');
			$testtype->targetTAT = Input::get('targetTAT');
			$testtype->prevalence_threshold = Input::get('prevalence_threshold');

			try{
				$testtype->save();
				$testtype->setSpecimenTypes(Input::get('specimentypes'));
				$testtype->setMeasures(Input::get('measures'));
			}catch(QueryException $e){
				Log::error($e);
			}

			// redirect
			return Redirect::route('testtype.index')
						->with('message', 'The test type details were successfully updated!');
		}
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
	 * Remove the specified resource from storage (soft delete).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the testtype
		$testtype = TestType::find($id);

		$testtype->delete();

		// redirect
		return Redirect::route('testtype.index')->with('message', 'The test type was successfully deleted!');
	}

}