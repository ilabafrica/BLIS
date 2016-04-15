<?php

class BlisClientController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get available equipment
		$client = BlisClient::lists('equipment_name', 'id');
		return View::make('instrument.blisClient')->with('client', $client);
	}

	/**
	 * Get details of the given client
	 *
	 * @return Response
	 */
	public function details()
	{
		$id = Input::get('equip');
		$client = BlisClient::find($id);
		$client->feed = $client->feed($client->feed_source);
		$client->comm = $client->comm($client->comm_type);
		$client->lab = $client->testCategory->name;
		return json_encode($client);
	}

	/**
	 * Get config properties of the given client
	 *
	 * @return Response
	 */
	public function properties()
	{
		$id = Input::get('client');
		$client = BlisClient::find($id);
		$properties = DB::table('equip_config')->where('equip_id', $client->id)->get();
		foreach ($properties as $property)
		{
			$conf = DB::table('ii_quickcodes')->where('feed_source', $client->feed_source)->where('id', $property->prop_id)->first();
			$property->config_prop = $conf->config_prop;
		}
		return json_encode($properties);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
	public function update()
	{
		//
		$equip_name = Input::get('equipment_name');
		$client = BlisClient::find(BlisClient::getClientIdByName($equip_name));
		foreach(Input::all() as $key => $value)
		{
			if(stripos($key, 'prop') !==FALSE)
			{
				$prop_id = self::strip($key);
				DB::table('equip_config')->where('equip_id', $client->id)->where('prop_id', $prop_id)->update(array('prop_value' => $value));
			}
		}
		$url = Session::get('SOURCE_URL');
            
    	return Redirect::to($url)->with('message', trans('messages.config-successfully-updated'));
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
	 * Remove the specified begining of text to get Id alone.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function strip($field)
	{
		if(($pos = strpos($field, '_')) !== FALSE)
		return substr($field, $pos+1);
	}
}
