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
		$commodities = Inventory::lists('commodity', 'id');
		
		return View::make('inventory.issues')->with('commodities', $commodities);
	}


    public function labTopup()
	{
		$commodities = InventoryLabTopup::orderBy('date', 'ASC')->get();
		return View::make('inventory.labTopup')->with('commodities',$commodities);
		//return View::make('inventory.labTopup');
	}

    public function formLabTopup()
	{
		
		return View::make('inventory.formLabTopup');
	}

	  

	public function stockTakeCard()
	{
		$commodities = Inventory::orderBy('commodity', 'ASC')->get();
		return View::make('inventory.stockTakeCard')->with('commodities', $commodities);
		
		//return View::make('inventory.stockTakeCard');
	}
	public function receiptsList()
	{
		$commodities = Inventory::orderBy('commodity', 'ASC')->get();
		return View::make('inventory.receiptsList')->with('commodities', $commodities);
	}


		public function editReceipts($id)
	{
		$commodity = Inventory::find($id);
		return View::make('inventory.editReceipts')->with('commodity', $commodity);
	}

	    public function editIssues($id)
	{
		$commodity = InventoryIssues::find($id);
		return View::make('inventory.editIssues')->with('commodity', $commodity);
	}

	    public function editLabTopUp($id)
	{
		$commodity = InventoryLabTopup::find($id);
		return View::make('inventory.editLabTopUp')->with('commodity', $commodity);
	}
	public function issuesList()
	{
		$issues = InventoryIssues::orderBy('issue_date', 'ASC')->get();
		return View::make('inventory.issuesList')->with('issues', $issues);
	//return View::make('inventory.issuesList');
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


			$receipts = new Inventory;
			$receipts->receipt_date = Input::get('lab-receipt-date');
			$receipts->commodity = Input::get('commodity');
			$receipts->unit_of_issue = Input::get('unit-of-issue');
			$receipts->received_from = Input::get('received-from');
			$receipts->doc_no= Input::get('doc-no');
			$receipts->qty = Input::get('qty');
			$receipts->batch_no = Input::get('batch-no');
			$receipts->expiry_date= Input::get('expiry-date');
			$receipts->location = Input::get('location');
			$receipts->receivers_name = Input::get('receivers-name');
			$receipts->user_id= Auth::user()->id;

			try{
				$receipts->save();
			


				return Redirect::route('inventory.receiptsList')
					->with('message', 'Successfully added');




			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
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


		public function updateReceipts($id)
	{
					
			// Update
			$commodity = Inventory::find($id);
			$commodity->receipt_date = Input::get('receipt_date');
			$commodity->commodity = Input::get('commodity');
			$commodity->unit_of_issue = Input::get('unit_of_issue');
			$commodity->received_from = Input::get('received_from');
			$commodity->doc_no= Input::get('doc_no');
			$commodity->qty = Input::get('qty');
			$commodity->batch_no = Input::get('batch_no');
			$commodity->expiry_date= Input::get('expiry_date');
			$commodity->location = Input::get('location');
			$commodity->receivers_name = Input::get('receivers_name');
			$commodity->save();

			return Redirect::route('inventory.receiptsList')
					->with('message', 'Successfully updated');

		
	}

	    public function deleteReceipts($id)
	    {
		//Soft delete the patient
		$commodity = Inventory::find($id);
		$commodity->delete();

		// redirect
           return Redirect::route('inventory.receiptsList')
			->with('message', 'The commodity was successfully deleted!');
	}

	   public function deleteLabTopupCommodity($id)
	    {
		//Soft delete the patient
		$commodity = InventoryLabTopup::find($id);
		$commodity->delete();

		// redirect
           return Redirect::route('inventory.labTopup')
			->with('message', 'The commodity was successfully deleted!');
	}
		 public function deleteIssuedCommodity($id)
	    {
		//Soft delete the patient
		$commodity = InventoryIssues::find($id);
		$commodity->delete();

		// redirect
           return Redirect::route('inventory.issuesList')
			->with('message', 'The commodity issued was successfully deleted!');
	}


	public function store_FormLabTopup()
	{
		//Log::info("here");
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
			$labTopup->date = Input::get('date');
			$labTopup->commodity_id = Input::get('commodity');
			$labTopup->unit_of_issue = Input::get('unit-of-issue');
			$labTopup->current_bal= Input::get('current-bal');
			$labTopup->tests_done = Input::get('tests-done');
			$labTopup->order_qty = Input::get('order-qty');
			$labTopup->issue_qty= Input::get('issue-qty');
			//$labTopup->issued_by = Input::get('issued-by');
			$labTopup->receivers_name = Input::get('receivers-name');
			$labTopup->remarks = Input::get('remarks');
			$labTopup->issued_by= Auth::user()->id;

			try{
				$labTopup->save();
			


				return Redirect::route('inventory.labTopup')
					->with('message', 'Successfully added');




			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
	}


	public function store_FormStockTake()
	{
		//Log::info("here");
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
			$stockTake = new InventoryStockTake;
			$stockTake->code = Input::get('code');
			$stockTake->commodity = Input::get('commodity');
			$stockTake->unit_of_issue = Input::get('unit_of_issue');
			$stockTake->batch_no = Input::get('batch_no');
			$stockTake->expiry_date= Input::get('expiry_date');
			$stockTake->stock_bal = Input::get('qty_on_stock_card');
			$stockTake->physical_count = Input::get('physical-count');
			$stockTake->unit_price = Input::get('unit-price');
			$stockTake->total_price = Input::get('total-price');
			$stockTake->discrepancy = Input::get('discrepancy');
			$stockTake->remarks= Input::get('remarks');
			


			try{
				$labTopup->save();
			


				return Redirect::route('inventory.stoclTakeCard')
					->with('message', 'Successfully added');




			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
	}
			public function updateIssuedCommodities($id)
			{
					
			// Update
			$commodity = InventoryIssues::find($id);
			$commodity->issue_date = Input::get('issue_date');
			$commodity->commodity_id = Input::get('commodity_id');
			$commodity->doc_no= Input::get('doc_no');
			$commodity->batch_no = Input::get('batch_no');
			$commodity->expiry_date= Input::get('expiry_date');
            $commodity->qty_avl = Input::get('qty_avl');
			$commodity->qty_req = Input::get('qty_req');
			$commodity->destination = Input::get('destination');
			$commodity->receivers_name = Input::get('receivers_name');
			$commodity->save();

			return Redirect::route('inventory.issuesList')
					->with('message', 'Successfully updated');

		
	}

			public function updateLabTopup($id)
			{
					
			// Update
			$commodity = InventoryLabTopup::find($id);
			$commodity->date = Input::get('date');
			$commodity->commodity_id = Input::get('commodity_id');
			$commodity->unit_of_issue= Input::get('unit_of_issue');
			$commodity->current_bal = Input::get('current_bal');
			$commodity->tests_done= Input::get('tests_done');
            $commodity->order_qty = Input::get('order_qty');
			$commodity->issue_qty= Input::get('issue_qty');
			$commodity->issued_by = Input::get('issued_by');
			$commodity->receivers_name = Input::get('receivers_name');
			$commodity->remarks = Input::get('remarks');


			
			$commodity->save();

			return Redirect::route('inventory.labTopup')
					->with('message', 'Successfully updated');

		
	}

	public function store_stockTake()
	{
		//Log::info("here");
			$rules = array(
			
			'physical-count' => 'required',
			'discrepancy' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput();
		} else {
		

			$stock = new InventoryStockTake;
			$commodity->period_beginning = Input::get('start');
            $commodity->period_ending = Input::get('end');
			$stock->code = Input::get('doc_no');
			$stock->commodity = Input::get('commodity');
			$stock->unit_of_issue = Input::get('unit_of_issue');
			$stock->batch_no = Input::get('batch_no');
			$stock->expiry_date= Input::get('expiry_date');
			$stock->stock_bal = Input::get('qty');
			$stock->physical_count = Input::get('physical-count');
			$stock->unit_price= Input::get('unit-price');
			$stock->total_price = Input::get('	total-price');
			$stock->discrepancy = Input::get('discrepancy');

			try{
				$stock->save();
			


				return Redirect::route('inventory.labStockCard')
					->with('message', 'Successfully added');




			}catch(QueryException $e){
				Log::error($e);
			}
			
		}
	}

	public function commodityDropdown(){
        $input = Input::get('option');
        $commodities = Inventory::find($input);
        return Response::json($commodities);
    }


	

	

}