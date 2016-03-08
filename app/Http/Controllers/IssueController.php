<?php namespace App\Http\Controllers;

use Validator;
use App\Models\Issue;
use App\Models\TopupRequest;
use App\Models\Receipt;
use App\Models\User;
use Auth;
use Input;

class IssueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$issues = Issue::all();
		return view('issue.index')->with('issues', $issues);
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

		return view('issue.create')
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
			return redirect()->to('issue.index')->withErrors($validator);
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
			return redirect()->to('issue.index')
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
		return view('issue.edit')
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
			'receivers_name' => 'required',
			'quantity_issued' => 'required|integer',
			'batch_no' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return redirect()->to('issue.index')->withErrors($validator);
				
		} else {
			// Update
			$issue = Issue::find($id);
			$issue->receipt_id = Input::get('batch_no');
			$issue->topup_request_id = Input::get('topup_request_id');
			$issue->quantity_issued = Input::get('quantity_issued');
			$issue->issued_to = Input::get('receivers_name');
			$issue->user_id = Auth::user()->id;
			$issue->remarks = Input::get('remarks');

			$issue->save();

			return redirect()->to('issue.index')
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
		return redirect()->to('issue.index')->with('message', trans('messages.issue-succesfully-deleted'));
	}

}
