<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\BlisClientRequest;
use App\Models\BlisClient;
use Response;
use Auth;
use Session;
use Lang;

class BlisClientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get available equipment
		$client = ['' => ' - '] + BlisClient::lists('equipment_name', 'id')->all();
		return view('instrument.blisClient')->with('client', $client);
	}

	/**
	 * Get details of the given client
	 *
	 * @return Response
	 */
	public function details(BlisClient $request)
	{
		$id = $request->equip;
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
	public function properties(BlisClient $request)
	{
		$id = $request->client;
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
