<?php

class CommodityController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		


		return View::make('inventory.commodities');
	
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
         $rules = array(			
			'commodity' => 'required',
			'item-code' => 'required'
			
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
			$issues->commodity_id= Input::get('commodity');
			$issues->batch_no= Input::get('batch_no');
			$issues->expiry_date= Input::get('expiry_date');
			$issues->qty_avl= Input::get('qty_avl');
			$issues->qty_req = Input::get('qty-req');
			$issues->destination = Input::get('destination');
			$issues->receivers_name = Input::get('receivers-name');

			$getQtyAvl =Input::get('qty_avl');
			$QtyIssued=Input::get('qty-req');
			$stock_bal= $getQtyAvl- $QtyIssued;
			$issues->stock_balance =$stock_bal;
			try{
				$issues->save();
				return Redirect::route('inventory.issuesList')
			->with('message', 'Successfully issued the commodity');
           
          		
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
