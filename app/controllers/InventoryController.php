<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing patient records 
 *
 */
class InventoryController extends \BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$commodities = InventoryReceipt::all();
		return View::make('inventory.labStockCard')->with('commodities', $commodities);
	}

	public function labStockCard()
	{
		return View::make('inventory.labStockCard');
	}

	public function receipts(){
		$commodities = InventoryCommodity::lists('name', 'id');
		$metrics = Metric::lists('name', 'id');
		$suppliers = Suppliers::lists('name', 'id');
		return View::make('inventory.receipts')
				->with('commodities', $commodities)
				->with('metrics', $metrics)
				->with('suppliers', $suppliers);
	}


	public function issues(){
		$receipts = InventoryReceipt::all();
		$commodities = InventoryCommodity::has('receipts')->lists('name', 'id');

		return View::make('inventory.issues')
				->with('commodities', $commodities)
				->with('receipts', $receipts);
	}


	public function labTopup()
	{
		$labTopUps = InventoryLabTopup::all();
		return View::make('inventory.labTopup')->with('labTopUps',$labTopUps);
	}

	public function formLabTopup()
	{
		$commodities = InventoryReceipt::all();
		$inventory= InventoryCommodity::has('receipts')->lists('name', 'id');

		return View::make('inventory.formLabTopup')->with('commodities', $commodities)
		->with('inventory', $inventory);;
	}

	public function stockTakeCard()
	{
		$commodities = InventoryReceipt::all();
		return View::make('inventory.stockTakeCard')->with('commodities', $commodities);
	}

	public function receiptsList()
	{
		$inventoryReceipts = InventoryReceipt::all();
		return View::make('inventory.receiptsList')->with('inventoryReceipts', $inventoryReceipts);
	}

	public function editReceipts($id) 
	{
		$commodity = InventoryReceipt::find($id);
		$metrics= Metric::all()->lists('name', 'id');
		$suppliers= Suppliers::all()->lists('name', 'id');
		$commodities= InventoryCommodity::all()->lists('name', 'id');

		return View::make('inventory.editReceipts')
				->with('commodity', $commodity)
				->with('metrics', $metrics)
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
	}

	public function editIssues($id)
	{
		$commodity = InventoryIssues::find($id);
		$commodities= InventoryCommodity::all()->lists('name', 'id');
		return View::make('inventory.editIssues')
			->with('commodities', $commodities)
			->with('commodity', $commodity);
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
	}

	public function store_receipts()
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
			return Redirect::route('inventory.receiptsList')
					->with('message', 'Successfully added');

		}
	}

	public function store_issues(){
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


	public function updateReceipts($id)
	{
			// Update
			$receipt = InventoryReceipt::find($id);
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

			return Redirect::route('inventory.receiptsList')
				->with('message', 'Successfully updated');
	}

	    public function deleteReceipts($id)
	    {
		//Soft delete the patient
		$commodity = InventoryReceipt::find($id);
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
			$labTopup->inventory_commodity_id = Input::get('commodity');
			$labTopup->current_bal= Input::get('current-bal');
			$labTopup->tests_done = Input::get('tests-done');
			$labTopup->order_qty = Input::get('order-qty');
			$labTopup->issue_qty= Input::get('issue-qty');
			$labTopup->receivers_name = Input::get('receivers-name');
			$labTopup->remarks = Input::get('remarks');
			$labTopup->user_id = Auth::user()->id;
			$labTopup->save();

			return Redirect::route('inventory.labTopup')
				->with('message', 'Successfully added');
		}
	}

	public function updateIssuedCommodities($id)
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

	public function updateLabTopup($id)
	{
		// Update
		$commodity = InventoryLabTopup::find($id);
		$commodity->date = Input::get('date');
		$commodity->inventory_commodity_id = Input::get('commodity_id');
		$commodity->inventory_metrics_id= Input::get('unit_of_issue');
		$commodity->current_bal = Input::get('current_bal');
		$commodity->tests_done= Input::get('tests_done');
        $commodity->order_qty = Input::get('order_qty');
		$commodity->issue_qty= Input::get('issue_qty');
		$commodity->user_id = Input::get('issued_by');
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
			$stock->inventory_commodity = Input::get('commodity');
			$stock->inventory_metrics_id = Input::get('unit_of_issue');
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
		$commodities = InventoryReceipt::find($input);
		return Response::json($commodities);
	}
}