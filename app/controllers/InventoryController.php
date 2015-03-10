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
		$receipts = Receipt::all();
		return View::make('inventory.labStockCard')->with('commodities', $commodities);
	}

	public function labStockCard()
	{
		return View::make('inventory.labStockCard');
	}

	public function labTopup()
	{
		$labTopUps = InventoryLabTopup::all();
		return View::make('topup.index')->with('labTopUps',$labTopUps);
	}

	public function formLabTopup()
	{
		$receipts = Receipt::all();
		$commodities = Commodity::has('receipts')->lists('name', 'id');

		return View::make('topup.create')->with('receipts', $receipts)
			->with('commodities', $commodities);
	}

	public function stockTakeCard()
	{
		$receipts = Receipt::all();
		return View::make('inventory.stockTakeCard')->with('receipts', $receipts);
	}

	public function editLabTopUp($id)
	{
		$commodity = InventoryLabTopup::find($id);
		return View::make('topup.edit')->with('commodity', $commodity);
	}

	public function deleteLabTopupCommodity($id)
	{
		//Soft delete the patient
		$commodity = InventoryLabTopup::find($id);
		$commodity->delete();

		// redirect
		return Redirect::route('topup.index')
			->with('message', 'The commodity was successfully deleted!');
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

			return Redirect::route('topup.index')
				->with('message', 'Successfully added');
		}
	}

	public function updateLabTopup($id)
	{
		// Update
		$commodity = InventoryLabTopup::find($id);
		$commodity->date = Input::get('date');
		$commodity->inventory_commodity_id = Input::get('commodity_id');
		$commodity->metric_id= Input::get('unit_of_issue');
		$commodity->current_bal = Input::get('current_bal');
		$commodity->tests_done= Input::get('tests_done');
        $commodity->order_qty = Input::get('order_qty');
		$commodity->issue_qty= Input::get('issue_qty');
		$commodity->user_id = Input::get('issued_by');
		$commodity->receivers_name = Input::get('receivers_name');
		$commodity->remarks = Input::get('remarks');

		$commodity->save();

		return Redirect::route('topup.index')
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
			$stock->metric_id = Input::get('unit_of_issue');
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
}