<?php

use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;

/**
 *Contains functions for managing specimen types  
 *
 */
class SpecimenTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active specimentypes
			$specimentypes = SpecimenType::all();

		// Load the view and pass the specimentypes
		return View::make('specimentype.index')->with('specimentypes', $specimentypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create SpecimenType
		return View::make('specimentype.create');
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
			'name'       => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('specimentype/create')
				->withErrors($validator);
		} else {
			// store
			$specimentype = new SpecimenType;
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');

			try{
				$specimentype->save();
				Session::flash('message', 'Successfully created specimen type!');
				return Redirect::to('specimentype');
			}catch(QueryException $e){
				$errors = new MessageBag(array(
                	"Ensure that the specimen type name is unique."
                ));
				return Redirect::to('specimentype/create')
					->withErrors($errors);
			}
			
			// redirect
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
		//Show a specimentype
		$specimentype = SpecimenType::find($id);

		//Show the view and pass the $specimentype to it
		return View::make('specimentype.show')->with('specimentype', $specimentype);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the specimentype
		$specimentype = SpecimenType::find($id);

		//Open the Edit View and pass to it the $specimentype
		return View::make('specimentype.edit')->with('specimentype', $specimentype);
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
			return Redirect::to('specimentype/' . $id . '/edit')
				->withErrors($validator);
		} else {
			// Update
			$specimentype = SpecimenType::find($id);
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');
			$specimentype->save();

			// redirect
			Session::flash('message', 'The specimen type details were successfully updated!');
			return Redirect::to('specimentype');
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
		//Soft delete the specimentype
		$specimentype = SpecimenType::find($id);

		$specimentype->delete();

		// redirect
		Session::flash('message', 'The specimen 	type was successfully deleted!');
		return Redirect::to('specimentype');
	}

}