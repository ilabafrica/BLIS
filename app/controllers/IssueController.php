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
		$batches = Receipt::all()->lists('batch_no', 'id');
		$commodities = Commodity::has('receipts')->lists('name', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');

		return View::make('issue.create')
				->with('commodities', $commodities)
				->with('users', $users)
				->with('sections', $sections)
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
			'user' => 'required',
			'quantity_issued' => 'required|integer',
			'commodity' => 'required',
			'batch_no' => 'required',
			'lab_section' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// store
			$issue = new Issue;
			$issue->commodity_id = Input::get('commodity');
			$issue->batch_no = Input::get('batch_no');
			$issue->quantity_issued = Input::get('quantity_issued');
			$issue->test_category_id = Input::get('lab_section');
			$issue->user_id = Input::get('user');

			$issue->save();
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
		$batches = Receipt::all()->lists('batch_no', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');
		//To DO:create function for this
		$available = Receipt::where('commodity_id', '=', $issue->commodity_id)->orderBy('created_at', 'DESC')->first()->qty;
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
			'user' => 'required',
			'quantity_issued' => 'required|integer',
			'commodity' => 'required',
			'batch_no' => 'required',
			'lab_section' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// Update
			$issue = Issue::find($id);
			$issue->commodity_id = Input::get('commodity');
			$issue->batch_no = Input::get('batch_no');
			$issue->quantity_issued = Input::get('quantity_issued');
			$issue->test_category_id = Input::get('lab_section');
			$issue->user_id = Input::get('user');

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

	/**
	* for autofilling issue form, from db data
	*/
	public function issueDropdown($id){
		$receipt = Receipt::where('commodity_id', '=', $id)->orderBy('created_at', 'DESC')->first();
		return Response::json($receipt);
	}

}
