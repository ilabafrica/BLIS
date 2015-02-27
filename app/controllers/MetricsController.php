<?php

class MetricsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$metrics = Metrics::orderBy('name', 'ASC')->get();
		return View::make('inventory.metricsList')->with('metrics', $metrics);
		//return View::make('inventory.metricsList');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inventory.metrics');
	}


	public function store()
	{
		//
         $rules = array(			
			'name' => 'required|unique:inventory_metrics,name');
		$validator = Validator::make(Input::all(), $rules);

		
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$metric = new Metrics;
			$metric->name= Input::get('name');
			$metric->description= Input::get('description');
			
			try{

				$metric->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-creating-metric')) ->with('activemetric', $metric ->id);
          		
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
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$metrics = Metrics::find($id);
		

		//Open the Edit View and pass to it the $patient
		return View::make('inventory.editMetrics')->with('metrics', $metrics);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{//Validate
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
		// Update
			$metric = Metrics::find($id);
			$metric->name= Input::get('name');
			$metric->description= Input::get('description');
			$metric->save();

			$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-updating-metric')) ->with('activemetric', $metric ->id);
          		
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


}
