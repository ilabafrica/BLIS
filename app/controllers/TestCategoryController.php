<?php

use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;

class TestCategoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all test categories
		$testcategory = TestCategory::all();
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
		$rules =array(
			'name' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		//process
		if($validator->fails()){
			return Redirect::to('test/create')->withErrors($validator)->withErrors(Input::except('password'));
		}else{
			//store
			$testcategory = new TestCategory;
			$testcategory->name = Input::get('name');
			$testcategory->description = Input::get('description');
			try{
				$testcategory->save();
				Session::flash('message','Successfully created test category');
				return Redirect::to('testcategory');
			}catch(QueryException $e){
				$errors = new MessageBag(array('The lab section your registering already exists!'));
				return Redirect::to(test/create)->withErrors($errors)->withInput(Input::except('password'));
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
		$rules = array(
			'name'       => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('testcategory/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// Update
			$testcategory = TestCategory::find($id);
			$testcategory->name = Input::get('name');
			$testcategory->description = Input::get('description');
			$testcategory->save();

			// redirect
			Session::flash('message', 'The lab section were successfully updated!');
			return Redirect::to('testcategory');
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
		Session::flash('message', 'The lab section was successfully deleted!');
		return Redirect::to('testcategory');
	}


}