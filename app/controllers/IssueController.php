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
	 * Show the form for dispatching the resource to the bench.
	 *
	 * @return Response
	 */
	public function dispatch($id)
	{
		$topupRequest = TopupRequest::find($id);
		$batches = Receipt::where('commodity_id', '=', $topupRequest->commodity_id)->lists('batch_no', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');

		return View::make('issue.create')
				->with('topupRequest', $topupRequest)
				->with('users', $users)
				->with('batches', $batches);
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
			'batch_no' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
				
		} else {
			// store
			$issue = new Issue;
			$issue->receipt_id = Input::get('batch_no');
			$issue->topup_request_id = Input::get('topup_request_id');
			$issue->quantity_issued = Input::get('quantity_issued');
			$issue->issued_to = Input::get('receivers_name');
			$issue->user_id = Auth::user()->id;
			$issue->remarks = Input::get('remarks');

			try{
			$issue->save();
			return Redirect::route('issue.index')
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
		//
		$issue = Issue::find($id);
		$commodities= Commodity::all()->lists('name', 'id');
		$batches = Receipt::all()->lists('batch_no', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');
		//To DO:create function for this
		$available = $issue->topupRequest->commodity->available();
		return View::make('issue.edit')
			->with('commodities', $commodities)
			->with('available', $available)
			->with('users', $users)
			->with('sections', $sections)
			->with('issue', $issue)
			->with('batches', $batches);
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
			'issued_to' => 'required',
			'quantity_issued' => 'required|integer',
			'batch_no' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// Update
			$issue = Issue::find($id);
			$issue->receipt_id = Input::get('batch_no');
			$issue->topup_request_id = Input::get('topup_request_id');
			$issue->quantity_issued = Input::get('quantity_issued');
			$issue->issued_to = Input::get('issued_to');
			$issue->user_id = Auth::user()->id;
			$issue->remarks = Input::get('remarks');

			$issue->save();

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

}
