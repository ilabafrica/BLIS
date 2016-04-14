<?php

class RegionTypeTierController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		//
		$regionType = RegionType::find($id);
		return View::make('regiontype.tier.index')->with('regionType', $regionType);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createTier($id)
	{
		//
		$region_type_id = $id;
		return View::make('regiontype.tier.create')->with('region_type_id', $region_type_id);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [
			'name'			=>	'required'
		];
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
			//store region-type first
			$region_type = new RegionType;
			$region_type->name = Input::get('name');
			$region_type->user_id = Auth::user()->id;
			$region_type->save();
			$region_type_tier = new RegionTypeTier;
			$region_type_tier->region_type_id = $region_type->id;
			$region_type_tier->tier_id = Input::get('tier_id');
			$region_type_tier->user_id = Auth::user()->id;
			try{
				$region_type_tier->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-creating-record'));
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
