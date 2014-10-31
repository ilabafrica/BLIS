<?php

use Illuminate\Database\QueryException;

/**
 * Contains functions for managing specimen types  
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
			$specimentypes = SpecimenType::paginate(Config::get('kblis.page-items'));

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
		$rules = array('name' => 'required|unique:specimen_types,name');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$specimentype = new SpecimenType;
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');

			try{
				$specimentype->save();
				return Redirect::route('specimentype.index')
                        ->with('message', 'messages.success-creating-specimen-type');
			}catch(QueryException $e){
                Log::error($e);
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
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$specimentype = SpecimenType::find($id);
			$specimentype->name = Input::get('name');
			$specimentype->description = Input::get('description');
			$specimentype->save();

			// redirect
			return Redirect::route('specimentype.index')
                    ->with('message', 'messages.success-updating-specimen-type');
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
		$inUseByTesttype = $specimentype->testTypes->toArray();
		$inUseBySpecimen = $specimentype->specimen->toArray();
		if (empty($inUseByTesttype) && empty($inUseBySpecimen)) {
		    // The specimen type is not in use
			$specimentype->delete();
		} else {
		    // The specimen type is in use
		    return Redirect::route('specimentype.index')->with('message', 'messages.failure-specimen-type-in-use');
		}
		// redirect
		return Redirect::route('specimentype.index')
                    ->with('message', 'messages.success-deleting-specimen-type');
	}
}