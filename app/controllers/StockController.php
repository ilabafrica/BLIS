<?php

class StockController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all stocks
		$stocks = Stock::orderBy('name', 'ASC')->get();
		//Load the view and pass the stocks
		return View::make('inventory.stock.index')->with('stocks', $stocks);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create stock
		return View::make('inventory.stock.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array(
			'item_id'   => 'required:inv_supply,item_id',
            'supplier_id'   => 'required:inv_supply,supplier_id'
		);
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$stock = new Stock;
			$stock->item_id = Input::get('item_id');
	        $stock->lot = Input::get('lot');
	        $stock->batch_no = Input::get('batch_no');
	        $stock->expiry_date = Input::get('expiry_date');
	        $stock->manufacturer = Input::get('manufacturer');
	        $stock->supplier_id = Input::get('supplier_id');
	        $stock->quantity_supplied = Input::get('quantity_supplied');
	        $stock->cost_per_unit = Input::get('cost_per_unit');
	        $stock->date_of_reception = Input::get('date_of_reception');
	        $stock->remarks = Input::get('remarks');

			$stock->user_id = Auth::user()->id;
			try{
				$stock->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.record-successfully-saved')) ->with('activestock', $stock ->id);
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
		//show a stock
		$stock = Stock::find($id);
		//show the view and pass the $stock to it
		return View::make('inventory.stock.show')->with('stock', $stock);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the stock
		$stock = Stock::find($id);

		//Open the Edit View and pass to it the $stock
		return View::make('inventory.stock.edit')->with('stock', $stock);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate
		$rules = array(
			'item_id'   => 'required:inv_supply,item_id',
            'supplier_id'   => 'required:inv_supply,supplier_id'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			//store
			$stock = Stock::find($id);
			$stock->item_id = Input::get('item_id');
	        $stock->lot = Input::get('lot');
	        $stock->batch_no = Input::get('batch_no');
	        $stock->expiry_date = Input::get('expiry_date');
	        $stock->manufacturer = Input::get('manufacturer');
	        $stock->supplier_id = Input::get('supplier_id');
	        $stock->quantity_supplied = Input::get('quantity_supplied');
	        $stock->cost_per_unit = Input::get('cost_per_unit');
	        $stock->date_of_reception = Input::get('date_of_reception');
	        $stock->remarks = Input::get('remarks');

			$stock->user_id = Auth::user()->id;
			$stock->save();

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activestock', $stock->id);
		}
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
	/**
	 * Remove the specified resource from storage (soft delete).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the stock
		$stock = Stock::find($id);
		$url = Session::get('SOURCE_URL');
        
        return Redirect::to($url)
		->with('message', trans('messages.record-successfully-deleted'));
	}
	/**
	 * Stock usage
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function usage($id)
	{
		//	Get stock
		$stock = Stock::find($id);
		//show the view and pass the $stock to it
		return View::make('inventory.stock.usage')->with('stock', $stock);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function stockUsage()
	{
		//Validate
		$rules = array(
			'stock_id'   => 'required:inv_usage,stock_id'
			'request_id'   => 'required:inv_usage,request_id'
		);
		$validator = Validator::make(Input::all(), $rules);
		//process
		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
			$usage = new Usage;
	        $usage->stock_id = Input::get('stock_id');
	        $usage->request_id = Input::get('request_id');
	        $usage->quantity_used = Input::get('quantity_used');
	        $usage->date_of_usage = Input::get('date_of_usage');
	        $usage->remarks = Input::get('remarks');
	        $usage->user_id = Auth::user()->id;
	        $usage->save();
	        $url = Session::get('SOURCE_URL');
        
	        return Redirect::to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
	    }
	}
	/**
	 * lot usage
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function lot($id)
	{
		//	Get lot usage
		$lot = Usage::find($id);
		//show the view and pass the $stock to it
		return View::make('inventory.stock.lot')->with('lot', $lot);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function lotUsage()
	{
		$id = Input::get('id');
		$usage = Usage::findOrFail($id);
        $usage->stock_id = Input::get('stock_id');
        $usage->quantity_used = Input::get('quantity_used');
        $usage->date_of_usage = Input::get('date_of_usage');
        $usage->remarks = Input::get('remarks');
        $usage->user_id = Auth::user()->id;
        $usage->save();
        $url = Session::get('SOURCE_URL');
    
        return Redirect::to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
	}
}
