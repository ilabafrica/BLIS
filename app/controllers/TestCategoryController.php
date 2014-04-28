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
		$test = TestCategory::all();
		//Load the view and pass the test categories
		return View::make('test_category.index')->with('test',$test);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create test category
		return View::make('test_category.create');
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
			$test_category = new TestCategory;
			$test_category->name = Input::get('name');
			$test_category->description = Input::get('description');
			try{
				$test_category->save();
				Session::flash('message','Successfully created test category');
				return Redirect::to('test_category');
			}catch(QueryException $e){
				$errors = new MessageBag(array('The test category your registering already exists!'));
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
		$test_category = TestCategory::find($id);
		//show the view and pass $test_category to it
		return View::make('test_category.show')->with('test_category',$test_category);
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
		$test_category = TestCategory::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('test_category.edit')->with('test_category', $test_category);
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
			return Redirect::to('test_category/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// Update
			$test_category = TestCategory::find($id);
			$test_category->name = Input::get('name');
			$test_category->description = Input::get('description');
			$test_category->save();

			// redirect
			Session::flash('message', 'The test category were successfully updated!');
			return Redirect::to('test_category');
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
		$test_category = TestCategory::find($id);

		$test_category->delete();

		// redirect
		Session::flash('message', 'The test category was successfully deleted!');
		return Redirect::to('test_category');
	}


}