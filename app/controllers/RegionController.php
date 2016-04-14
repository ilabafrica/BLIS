<?php

class RegionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Get all regions
		$regions = Region::all();
		
		return View::make('region.index', compact('regions'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all regiontypes for select list
		$regionTypes = RegionType::lists('name', 'id');

		return View::make('region.create', compact('regionTypes'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	    $region = new Region;
        $region->name =Input::get('name');
        $region->region_type_id = Input::get('regiontype_id');
        $region->user_id = Auth::user()->id;;
        $region->save();

       
        $url = Session::get('SOURCE_URL');
			
			return Redirect::to($url)

			->with('message', 'County created successfully.');
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
