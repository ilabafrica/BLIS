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
		$issues = Issue::all();
		return View::make('issue.index')->with('issues', $issues);
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
			'receivers_name' => 'required',
			'quantity_issued' => 'required|integer',
			'commodity' => 'required',
			'qty_avl' => 'required|integer',
			'destination' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// store
			$issues = new Issue;
			$issues->doc_no= Input::get('doc_no');
			$issues->commodity_id = Input::get('commodity');
			$issues->batch_no= Input::get('batch_no');
			$issues->expiry_date= Input::get('expiry_date');
			$issues->qty_req = Input::get('quantity_issued');
			$issues->destination = Input::get('destination');
			$issues->receivers_name = Input::get('receivers_name');

			$issues->save();
			return Redirect::route('issue.index')
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
		$issue = Issue::find($id);
		$commodities= Commodity::all()->lists('name', 'id');
		$available = Receipt::where('commodity_id', '=', $issue->commodity_id)->orderBy('created_at', 'DESC')->first()->qty;
		return View::make('issue.edit')
			->with('commodities', $commodities)
			->with('available', $available)
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
		$rules = array(
			'receivers_name' => 'required',
			'quantity_issued' => 'required|integer',
			'commodity' => 'required',
			'qty_avl' => 'required|integer',
			'destination' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// Update
			$commodity = Issue::find($id);
			$commodity->issue_date = Input::get('issue-date');
			$commodity->inventory_commodity_id = Input::get('commodity');
			$commodity->doc_no= Input::get('doc-no');
			$commodity->batch_no = Input::get('batch-no');
			$commodity->expiry_date= Input::get('expiry-date');
			$commodity->qty_avl = Input::get('qty-avl');
			$commodity->qty_req = Input::get('qty-req');
			$commodity->destination = Input::get('destination');
			$commodity->receivers_name = Input::get('receivers-name');

			$commodity->save();

			return Redirect::route('issue.index')
					->with('message', 'Successfully updated');
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
		$issue = Issue::find($id);
		$issue->delete();

		// redirect
		return Redirect::route('issue.index')->with('message', trans('messages.issue-succesfully-deleted'));
	}

	/**
	* for autofilling issue form, from db data
	*/
	public function issueDropdown($id){
		$receipt = Receipt::where('commodity_id', '=', $id)->orderBy('created_at', 'DESC')->first();
		return Response::json($receipt);
	}

}
