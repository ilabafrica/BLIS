<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing patient records 
 *
 */
class inventoryController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commodities = Inventory::orderBy('commodity', 'ASC')->get();
		return View::make('inventory.labStockCard')->with('commodities', $commodities);
	}

	public function labStockCard()
	{
		
		//$commodities = Inventory::find($id);
		

 		
		return View::make('inventory.labStockCard');
	}
	public function receipts()
	{
		return View::make('inventory.receipts');
	}


	public function issues()
	{
		
		return View::make('inventory.issues');
	}


    public function labTopup()
	{
		
		return View::make('inventory.labTopup');
	}


	public function stockTakeCard()
	{
		//$commodities = Inventory::orderBy('commodity', 'ASC')->get();

		// Load the view and pass the commoditi
		
		return View::make('inventory.stockTakeCard');
	}
	
	
    public function store_issues(){
	
 		  $rules = array(			
			'commodity' => 'required',
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
			$issues->commodity_id= Input::get('commodity');
			$issues->qty_req = Input::get('qty-req');
			$issues->destination = Input::get('destination');
			$issues->receivers_name = Input::get('receivers-name');

			try{
				$issues->save();
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'Successfully issued the commodity');
			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
	}
	public function store_receipts()
	{
		//Log::info("here");
			$rules = array(
			
			'commodity' => 'required',
			'doc-no' => 'required',
			'qty' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
			// store
			$receipts = new Inventory;
			$receipts->receipt_date = Input::get('lab-receipt-date');
			$receipts->commodity = Input::get('commodity');
			$receipts->received_from = Input::get('received-from');
			$receipts->doc_no= Input::get('doc-no');
			$receipts->qty = Input::get('qty');
			$receipts->batch_no = Input::get('batch-no');
			$receipts->expiry_date= Input::get('expiry-date');
			$receipts->location = Input::get('location');
			$receipts->receivers_name = Input::get('receivers-name');

			try{
				$receipts->save();
			


				return Redirect::route('inventory.labStockCard')
					->with('message', 'Successfully added');




			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
	}
		
	

	

}