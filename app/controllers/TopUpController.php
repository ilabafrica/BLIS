<?php

class TopUpController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$labTopUps = InventoryLabTopup::all();
		return View::make('topup.index')->with('labTopUps',$labTopUps);
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

		return View::make('topup.create')->with('receipts', $receipts)
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
			'order-qty' => 'required',
			'issue-qty' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// store
			$labTopup = new InventoryLabTopup;
			$labTopup->commodity_id = Input::get('commodity');
			$labTopup->current_bal= Input::get('current-bal');
			$labTopup->tests_done = Input::get('tests-done');
			$labTopup->order_qty = Input::get('order-qty');
			$labTopup->issue_qty= Input::get('issue-qty');
			$labTopup->receivers_name = Input::get('receivers-name');
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
		$topUps = InventoryLabTopup::find($id);
		return View::make('topup.edit')->with('topUps', $topUps);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Update
		$commodity = InventoryLabTopup::find($id);
		$commodity->date = Input::get('date');
		$commodity->commodity_id = Input::get('commodity_id');
		$commodity->metric_id= Input::get('unit_of_issue');
		$commodity->current_bal = Input::get('current_bal');
		$commodity->tests_done= Input::get('tests_done');
        $commodity->order_qty = Input::get('order_qty');
		$commodity->issue_qty= Input::get('issue_qty');
		$commodity->user_id = Input::get('issued_by');
		$commodity->receivers_name = Input::get('receivers_name');
		$commodity->remarks = Input::get('remarks');

		$commodity->save();

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
		$commodity = InventoryLabTopup::find($id);
		$commodity->delete();

		// redirect
		return Redirect::route('topup.index')
			->with('message', 'The commodity was successfully deleted!');
	}


}
