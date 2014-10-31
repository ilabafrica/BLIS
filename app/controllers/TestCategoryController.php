<?php

use Illuminate\Database\QueryException;

/**
 * Contains test categories a.k.a lab sections
 * A classification of test types
 */
class TestCategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all test categories
		$testcategory = TestCategory::paginate(Config::get('kblis.page-items'));
		//Load the view and pass the test categories
		return View::make('testcategory.index')->with('testcategory',$testcategory);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create test category
		return View::make('testcategory.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$validator = Validator::make(Input::all(), TestCategory::$rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$testcategory = new TestCategory;
			$testcategory->name = Input::get('name');
			$testcategory->description = Input::get('description');
			try{
				$testcategory->save();
				return Redirect::route('testcategory.index')
							->with('message', trans('messages.success-creating-test-category'));
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
		//show a test category
		$testcategory = TestCategory::find($id);
		//show the view and pass the $testcategory to it
		return View::make('testcategory.show')->with('testcategory',$testcategory);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the patient
		$testcategory = TestCategory::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('testcategory.edit')->with('testcategory', $testcategory);
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
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// Update
			$testcategory = TestCategory::find($id);
			$testcategory->name = Input::get('name');
			$testcategory->description = Input::get('description');
			$testcategory->save();

			// redirect
			return Redirect::route('testcategory.index')->with('message', trans('messages.success-updating-test-category'));
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
		//Soft delete the test category
		$testcategory = TestCategory::find($id);

		$testcategory->delete();

		// redirect
		return Redirect::route('testcategory.index')->with('message', trans('messages.success-deleting-test-category'));
	}


}