<?php namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Http\Requests\UsageRequest;
use App\Models\Stock;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Usage;
use App\Models\Barcode;
use Response;
use Session;
use Auth;
use Lang;

class StockController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
		//	Get item
		$item = Item::find($id);
		//	Barcode
		$barcode = Barcode::first();
		//Load the view and pass the stocks
		return view('inventory.stock.index')->with('item', $item)->with('barcode', $barcode);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//Create stock
		//	Get item
		$item = Item::find($id);
		//	Get suppliers for select list
		$suppliers = Supplier::lists('name', 'id');
		return view('inventory.stock.create')->with('item', $item)->with('suppliers', $suppliers);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StockRequest $request)
	{
		$stock = new Stock;
        $stock->item_id = $request->item_id;
        $stock->lot = $request->lot;
        $stock->batch_no = $request->batch_no;
        $stock->expiry_date = $request->expiry_date;
        $stock->manufacturer = $request->manufacturer;
        $stock->supplier_id = $request->supplier_id;
        $stock->quantity_supplied = $request->quantity_supplied;
        $stock->cost_per_unit = $request->cost_per_unit;
        $stock->date_of_reception = $request->date_of_reception;
        $stock->remarks = $request->remarks;
		$stock->user_id = Auth::user()->id;
		try{
			$stock->save();
			$url = session('SOURCE_URL');

			return redirect()->to($url)
				->with('message', trans('messages.record-successfully-saved')) ->with('activestock', $stock ->id);
		}catch(QueryException $e){
			Log::error($e);
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
		return view('inventory.stock.show', compact('stock'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get suppliers for select list
		$suppliers = Supplier::lists('name', 'id');
		//	Get stock
		$stock = Stock::find($id);
		//	Get initially saved supplier
		$supplier = $stock->supplier_id;

		//Open the Edit View and pass to it the $stock
		return view('inventory.stock.edit')->with('stock', $stock)->with('supplier', $supplier)->with('suppliers', $suppliers);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(StockRequest $request, $id)
	{
		$stock = Stock::findOrFail($id);
		$stock->item_id = $request->item_id;
        $stock->lot = $request->lot;
        $stock->batch_no = $request->batch_no;
        $stock->expiry_date = $request->expiry_date;
        $stock->manufacturer = $request->manufacturer;
        $stock->supplier_id = $request->supplier_id;
        $stock->quantity_supplied = $request->quantity_supplied;
        $stock->cost_per_unit = $request->cost_per_unit;
        $stock->date_of_reception = $request->date_of_reception;
        $stock->remarks = $request->remarks;
		$stock->user_id = Auth::user()->id;
		$stock->save();

		// redirect
		$url = session('SOURCE_URL');
        
        return redirect()->to($url)
			->with('message', trans('messages.record-successfully-updated')) ->with('activestock', $stock->id);
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
		$url = session('SOURCE_URL');
        
        return redirect()->to($url)
		->with('message', trans('messages.record-successfully-deleted'));
	}

	/**
	 * Stock usage
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function usage($id, $req = null)
	{
		//	Get stock
		$stock = Stock::find($id);
		//	Get Requests
		$requests = $stock->item->requests;
		if($req)
			$record = $req;
		else
			$record = 0;
		//show the view and pass the $stock to it
		return view('inventory.stock.usage')->with('stock', $stock)->with('requests', $requests)->with('record', $record);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function stockUsage(UsageRequest $request)
	{
		$usage = new Usage;
		$usage->stock_id = $request->stock_id;
		$usage->request_id = $request->request_id;
		$usage->quantity_used = $request->quantity_used;
		$usage->date_of_usage = $request->date_of_usage;
		$usage->issued_by = $request->issued_by;
		$usage->received_by = $request->received_by;
		$usage->remarks = $request->remarks;
		$usage->user_id = Auth::user()->id;


		$url = session('SOURCE_URL');
		if($usage->quantity_used>Stock::find((int)$usage->stock_id)->quantity())
		{
			return redirect()->back()->with('message', trans('messages.insufficient-stock'))->withInput($request->all());
		}
		else if($usage->quantity_used>Topup::find((int)$usage->request_id)->quantity_ordered)
		{
			return redirect()->back()->with('message', trans('messages.issued-greater-than-ordered'))->withInput($request->all());
		}
		else
		{
			$usage->save();        
			return redirect()->to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
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
		$lt = Usage::find($id);
		//	Get Requests
		$requests = Topup::all();
		//	Get request
		$request = $lt->request_id;
		//show the view and pass the $stock to it
		return view('inventory.stock.lot')->with('lt', $lt)->with('requests', $requests)->with('request', $request);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function lotUsage(UsageRequest $request)
	{
		$usage = Usage::findOrFail($request->id);
		$usage->stock_id = $request->stock_id;
		$usage->quantity_used = $request->quantity_used;
		$usage->date_of_usage = $request->date_of_usage;
		$usage->issued_by = $request->issued_by;
		$usage->received_by = $request->received_by;
		$usage->remarks = $request->remarks;
		$usage->user_id = Auth::user()->id;
		$url = session('SOURCE_URL');
		if($usage->quantity_used>Stock::find((int)$usage->stock_id)->quantity())
		{
			return redirect()->back()->with('message', trans('messages.insufficient-stock'))->withInput($request->all());
		}
		else if($usage->quantity_used>Topup::find((int)$usage->request_id)->quantity_ordered)
		{
			return redirect()->back()->with('message', trans('messages.issued-greater-than-ordered'))->withInput($request->all());
		}
		else
		{
			$usage->save();

			return redirect()->to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_stock', $usage->stock->id);
		}
	}
}