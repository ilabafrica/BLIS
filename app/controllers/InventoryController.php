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

	public function stockTakeCard()
	{
		$receipts = Receipt::all();
		return View::make('inventory.stockTakeCard')->with('receipts', $receipts);
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