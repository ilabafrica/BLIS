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
		return View::make('lot.create')->with('controls', $controls);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('number' => 'required|unique:lot,number');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('lot.index')->withErrors($validator)->withInput();
		} else {
			// Add
			$lot = new Lot;
			$lot->number = Input::get('number');
			$lot->description = Input::get('description');
			// redirect
			try{
				$lot->save();
				$url = Session::get('SOURCE_URL');
				return Redirect::to($url)
					->with('message', trans('messages.successfully-updated-lot'))->with('activelot', $lot ->id);
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
