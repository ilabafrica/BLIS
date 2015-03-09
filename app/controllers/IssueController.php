<?php

class IssueController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$issues = InventoryIssues::all();
		return View::make('inventory.issue.index')->with('issues', $issues);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$receipts = InventoryReceipt::all();
		$commodities = InventoryCommodity::has('receipts')->lists('name', 'id');

		return View::make('issue.create')
				->with('commodities', $commodities)
				->with('receipts', $receipts);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'receivers-name' => 'required',
			'qty-req' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// store
			$issues = new InventoryIssues;
			$issues->issue_date= Input::get('issue-date');
			$issues->doc_no= Input::get('doc-no');
			$issues->inventory_commodity_id = Input::get('commodity');
			$issues->batch_no= Input::get('batch-no');
			$issues->expiry_date= Input::get('expiry-date');
			$issues->qty_avl= Input::get('qty-avl');
			$issues->qty_req = Input::get('qty-req');
			$issues->destination = Input::get('destination');
			$issues->receivers_name = Input::get('receivers-name');

			$getQtyAvl =Input::get('qty_avl');
			$qtyIssued=Input::get('qty-req');
			$stockBal= $getQtyAvl- $qtyIssued;
			$issues->stock_balance =$stockBal;

			$issues->save();
			return Redirect::route('inventory.issuesList')
				->with('message', 'Successfully issued the commodity');
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
		$issue = InventoryIssues::find($id);
		$commodities= InventoryCommodity::all()->lists('name', 'id');
		return View::make('issues.edit')
			->with('commodities', $commodities)
			->with('issue', $issue);
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
		$commodity = InventoryIssues::find($id);
		$commodity->issue_date = Input::get('issue-date');
		$commodity->inventory_commodity_id = Input::get('commodity');
		$commodity->doc_no= Input::get('fdf_add_doc_javascript(fdf_document, script_name, script_code)no');
		$commodity->batch_no = Input::get('batch-no');
		$commodity->expiry_date= Input::get('expiry-date');
		$commodity->qty_avl = Input::get('qty-avl');
		$commodity->qty_req = Input::get('qty-req');
		$commodity->destination = Input::get('destination');
		$commodity->receivers_name = Input::get('receivers-name');

		$getQtyAvl =Input::get('qty-avl');
		$QtyIssued=Input::get('qty-req');
		$stock_bal= $getQtyAvl - $QtyIssued;
		$commodity->stock_balance =$stock_bal;

		$commodity->save();

		return Redirect::route('inventory.issuesList')
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
		//Soft delete the item
		$issue = InventoryIssues::find($id);
		$issue->delete();

		// redirect
		return Redirect::route('issue.index')->with('message', trans('messages.issue-succesfully-deleted'));
	}


}
