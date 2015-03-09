<?php

class ReceiptController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$receipts = Receipt::all();
		return View::make('receipt.index')->with('receipts', $receipts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$commodities = Commodity::lists('name', 'id');
		$metrics = Metric::lists('name', 'id');
		$suppliers = Supplier::lists('name', 'id');
		return View::make('receipt.create')
				->with('commodities', $commodities)
				->with('metrics', $metrics)
				->with('suppliers', $suppliers);
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
			'quantity' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			$receipts = new InventoryReceipt;
			$receipts->receipt_date = Input::get('lab-receipt-date');
			$receipts->inventory_commodity_id = Input::get('commodity');
			$receipts->inventory_suppliers_id = Input::get('received-from');
			$receipts->inventory_metrics_id = Input::get('metric');
			$receipts->doc_no= Input::get('doc-no');
			$receipts->qty = Input::get('quantity');
			$receipts->batch_no = Input::get('batch-no');
			$receipts->expiry_date= Input::get('expiry-date');
			$receipts->location = Input::get('location');
			$receipts->receivers_name = Input::get('receivers-name');
			$receipts->user_id= Auth::user()->id;

			$receipts->save();
			return Redirect::route('receipt.index')
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
		$receipts = Receipt::find($id);
		$metrics = Metric::all()->lists('name', 'id');
		$suppliers = Supplier::all()->lists('name', 'id');
		$commodities = Commodity::all()->lists('name', 'id');

		return View::make('receipt.edit')
				->with('receipts', $receipts)
				->with('metrics', $metrics)
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
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
		$receipt = Receipt::find($id);
		$receipt->receipt_date = Input::get('receipt_date');
		$receipt->inventory_commodity_id = Input::get('commodity');
		$receipt->inventory_suppliers_id = Input::get('received_from');
		$receipt->doc_no= Input::get('doc_no');
		$receipt->qty = Input::get('qty');
		$receipt->batch_no = Input::get('batch_no');
		$receipt->expiry_date= Input::get('expiry_date');
		$receipt->location = Input::get('location');
		$receipt->receivers_name = Input::get('receivers_name');
		$receipt->save();

		return Redirect::route('receipt.index')
			->with('message', trans('messags.receipt-succesfully-updated'));
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
		$receipt = Receipt::find($id);
		$receipt->delete();

		// redirect
		return Redirect::route('receipt.index')
			->with('message', trans('messages.receipt-succesfully-deleted'));
	}


}
