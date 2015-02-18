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
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.labStockCard');
	}

	public function labStockCard()
	{
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.labStockCard');
	}
	public function receipts()
	{
		// List all the active patients
			$receipts = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.receipts');
	}
	public function issues()
	{
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.issues');
	}

    public function labTopup()
	{
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.labTopup');
	}
	public function stockTakeCard()
	{
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('inventory.stockTakeCard');
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Log::info("here");
			$rules = array(
			
			'commodity'       => 'required',
			'doc-no' => 'required',
			'qty' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$receipts = new inventory;
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
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'Successfully added');
			}catch(QueryException $e){
				Log::error($e);
			}
			
			// redirect
		}
	}

	

}