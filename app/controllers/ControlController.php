<?php

class ControlController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$controls = Control::all();
		return View::make('control.index')->with('controls', $controls);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$instruments = Instrument::lists('name', 'id');
		$measureTypes = MeasureType::all();
		return View::make('control.create')
			->with('instruments', $instruments)
			->with('measureTypes', $measureTypes);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required',
		 			'instrument' => 'required|non_zero_key',
		 			'new-measures' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('control.create')->withErrors($validator)->withInput();
		} else {
			// Add
			$control = new Control;
			$control->name = Input::get('name');
			$control->description = Input::get('name');
			$control->save();

			if (Input::get('new-measures')) {
					$inputNewMeasures = Input::get('new-measures');
					$controlMeasure = New ControlMeasure;
					$controlMeasure->store($inputNewMeasures, $control->id);
			}
			// redirect
			return Redirect::to('control.index')
					->with('message', trans('messages.successfully-added-control'))
					->with('activeControl', $control ->id);
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


}
