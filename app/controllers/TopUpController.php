<?php

class TopUpController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$topupRequests = TopupRequest::all();
		return View::make('topup.index')->with('topupRequests', $topupRequests);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$receipts = Receipt::all();
		$commodities = Commodity::has('receipts')->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');

		return View::make('topup.create')
			->with('receipts', $receipts)
			->with('sections', $sections)
			->with('commodities', $commodities);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'commodity' => 'required',
			'lab_section' => 'required',
			'order_quantity' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
		return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// store
			$labTopup = new TopupRequest;
			$labTopup->commodity_id = Input::get('commodity');
			$labTopup->test_category_id = Input::get('lab_section');
			$labTopup->order_quantity = Input::get('order_quantity');
			$labTopup->remarks = Input::get('remarks');
			$labTopup->user_id = Auth::user()->id;
			$labTopup->save();

			return Redirect::route('topup.index')
				->with('message', 'Successfully added');
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
		$topupRequest = TopupRequest::find($id);
		$commodities = Commodity::has('receipts')->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');
		return View::make('topup.edit')
			->with('topupRequest', $topupRequest)
			->with('sections', $sections)
			->with('commodities', $commodities);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'commodity' => 'required',
			'order_quantity' => 'required',
			'lab_section' => 'required'
		);
		// Update
		$labTopup = TopupRequest::find($id);
		$labTopup->commodity_id = Input::get('commodity');
		$labTopup->test_category_id = Input::get('lab_section');
		$labTopup->order_quantity = Input::get('order_quantity');
		$labTopup->user_id = Auth::user()->id;
		$labTopup->remarks = Input::get('remarks');

		$labTopup->save();

		return Redirect::route('topup.index')
				->with('message', 'Successfully updated');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the patient
		$commodity = TopupRequest::find($id);
		$commodity->delete();

		// redirect
		return Redirect::route('topup.index')
			->with('message', 'The commodity was successfully deleted!');
	}

	/**
	* for autofilling issue form, from db data
	*/
	public function availableStock($id){
		$receipt = Commodity::find($id)->available();
		return Response::json(array('availableStock' => $receipt));
	}
}
