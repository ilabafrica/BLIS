<?php namespace App\Http\Controllers;

use App\Models\Commodity;
use Validator;
use Input;

class CommodityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commodities = Commodity::all();
		return view('commodity.index')->with('commodities', $commodities);
	}


	public function create()
	{
		$metrics = Metric::orderBy('name', 'ASC')->lists('name', 'id');
		return view('commodity.create')->with('metrics', $metrics);
	}

	public function store()
	{
		//
		$rules = array(
		'name' => 'required|unique:commodities,name',
		'description' => 'required',
		'unit_price' => 'required|numeric',
		'item_code' => 'required',
		'storage_req' => 'required',
		'min_level' => 'required|numeric',
		'max_level' => 'required|numeric',);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$commodity = new Commodity;
			$commodity->name= Input::get('name');
			$commodity->description= Input::get('description');
			$commodity->metric_id= Input::get('unit_of_issue');
			$commodity->unit_price= Input::get('unit_price');
			$commodity->item_code = Input::get('item_code');
			$commodity->storage_req = Input::get('storage_req');
			$commodity->min_level = Input::get('min_level');
			$commodity->max_level = Input::get('max_level');

			try{
				$commodity->save();
				return redirect()->to('commodity.index')
					->with('message', trans('messages.commodity-succesfully-added'));
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
		$metrics = Metric::orderBy('name', 'ASC')->lists('name', 'id');
		$commodity = Commodity::find($id);

		//Open the Edit View and pass to it the $patient
		return view('commodity.edit')->with('metrics', $metrics)->with('commodity', $commodity);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate
		$rules = array(
		'name' => 'required',
);
		$validator = Validator::make(Input::all(), $rules);

		// process the validation
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
		// Update
			$commodity = Commodity::find($id);
			$commodity->name= Input::get('name');
			$commodity->description= Input::get('description');
			$commodity->metric_id= Input::get('unit_of_issue');
			$commodity->unit_price= Input::get('unit_price');
			$commodity->item_code= Input::get('item_code');
			$commodity->storage_req= Input::get('storage_req');
			$commodity->min_level= Input::get('min_level');
			$commodity->max_level= Input::get('max_level');

			
		try{
			$commodity->save();
			return redirect()->to('commodity.index')
			->with('message', trans('messages.success-updating-commodity'))->with('activecommodity', $commodity ->id);
			}catch(QueryException $e){
				Log::error($e);
			}
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
		//Soft delete the item
		$commodity = Commodity::find($id);
		$commodity->delete();

		// redirect
		return redirect()->to('commodity.index')->with('message', trans('messages.commodity-succesfully-deleted'));
	}
}
