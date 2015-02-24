<?php

class LotController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Lists all lots
		$lots = Lot::all();
		return View::make('lot.index')->with('lots', $lots);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$controls = Control::lists('name', 'id');
		$measureTypes = MeasureType::all();
		return View::make('lot.create')->with('controls', $controls)->with('measureTypes', $measureTypes);
	}

	/**
	 * Returns an lotRanges.blade view depending 
	 * on the parametes received.
	 *
	 * @return View
	 */
	public function editRanges($controlId)
	{
		$controlMeasures = Control::find($controlId)->ControlMeasures;
		$measureTypes = MeasureType::all();
		return View::make('lot.lotRanges')->with('controlMeasures', $controlMeasures)->with('measureTypes', $measureTypes)->render();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('number' => 'required|unique:lots,number',
					'control' => 'required|non_zero_key',
					'measures' => 'required');
		$validator = Validator::make(Input::all(), $rules);
		// dd(Input::all());
		if ($validator->fails()) {
			return Redirect::route('lot.create')->withErrors($validator)->withInput();
		} else {
			// Add
			dd(Input::get('measures'));
			$lot = new Lot;
			$lot->number = Input::get('number');
			$lot->description = Input::get('description');
			$lot->save();

			if (Input::get('measures')) {
					$inputMeasures = Input::get('measures');
					$controlMeasure = New ControlMeasureController;
					$controlMeasure->saveRanges($inputMeasures, $lot->id);
			}
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
					->with('message', trans('messages.successfully-updated-lot'));
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
