<?php

class FacilityController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all facilities
		$facilities = Facility::paginate(Config::get('kblis.page-items'));
		//Load the view and pass the facilities
		return View::make('facility.index')->with('facilities',$facilities);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('facility.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required|unique:facilities,name');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			// Add
			$facility = new Facility;
			$facility->name = Input::get('name');
			// redirect
			try{
				$facility->save();
				return Redirect::route('facility.index')
					->with('message', trans('messages.successfully-updated-facility'));
			} catch(QueryException $e){
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
		//Get the facility
		$facility = Facility::find($id);

		return View::make('facility.edit')->with('facility', $facility);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate and check
		$rules = array('name' => 'required|unique:facilities,name');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			// Update
			$facility = Facility::find($id);
			$facility->name = Input::get('name');
			$facility->save();
			// redirect
			return Redirect::route('facility.index')
				->with('message', trans('messages.successfully-updated-facility'));
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Deleting the Item
		$facility = Facility::find($id);

		//Soft delete
		$facility->delete();

		// redirect
		return Redirect::route('facility.index')
			->with('message', trans('messages.successfully-deleted-facility'));
	}


}
