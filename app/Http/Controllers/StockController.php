<?php namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Http\Requests\UsageRequest;
use App\Models\Stock;
use App\Models\Item;
use App\Models\Supplier;
use App\Models\Usage;
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
		return view('stock.index', compact('item'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		//	Get item
		$item = Item::find($id);
		//	Get suppliers for select list
		$suppliers = Supplier::lists('name', 'id');
		return view('stock.create', compact('item', 'suppliers'));
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
        $stock->expiry_date = $request->expiry_date;
        $stock->manufacturer = $request->manufacturer;
        $stock->supplier_id = $request->supplier_id;
        $stock->quantity_supplied = $request->quantity_supplied;
        $stock->cost_per_unit = $request->cost_per_unit;
        $stock->date_of_reception = $request->date_of_reception;
        $stock->remarks = $request->remarks;
        $stock->user_id = 1;
        $stock->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-saved'))->with('active_stock', $stock ->id);
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
		return view('stock.show', compact('stock'));
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

        return view('stock.edit', compact('stock', 'suppliers', 'supplier'));
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
        $stock->expiry_date = $request->expiry_date;
        $stock->manufacturer = $request->manufacturer;
        $stock->supplier_id = $request->supplier_id;
        $stock->quantity_supplied = $request->quantity_supplied;
        $stock->cost_per_unit = $request->cost_per_unit;
        $stock->date_of_reception = $request->date_of_reception;
        $stock->remarks = $request->remarks;
        $stock->user_id = 1;
        $stock->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-updated'))->with('active_stock', $stock ->id);
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
		return view('stock.usage', compact('stock'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function stockUsage(UsageRequest $request)
	{
		$usage = new Usage;
        $usage->stock_id = 1;
        $usage->quantity_used = $request->quantity_used;
        $usage->date_of_usage = $request->date_of_usage;
        $usage->remarks = $request->remarks;
        $usage->user_id = 1;
        $usage->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-saved'))->with('active_stock', 1);
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
		return view('stock.lot', compact('lot'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function lotUsage(UsageRequest $request)
	{
		$id = $request->id;
		$usage = Usage::findOrFail($id);
        $usage->stock_id = 1;
        $usage->quantity_used = $request->quantity_used;
        $usage->date_of_usage = $request->date_of_usage;
        $usage->remarks = $request->remarks;
        $usage->user_id = 1;
        $usage->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-saved'))->with('active_stock', 1);
	}
}