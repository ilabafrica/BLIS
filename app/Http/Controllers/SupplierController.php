<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Response;
use Redirect;
use Auth;
use Session;
use Lang;

class SupplierController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$suppliers = Supplier::orderBy('name', 'ASC')->get();
		return view('supplier.index', compact('suppliers'))->with('suppliers', $suppliers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('inventory.supplier.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SupplierRequest $request)
	{
		$supplier = new Supplier;
		$supplier->name = $request->name;
		$supplier->phone = $request->phone;
		$supplier->email = $request->email;
		$supplier->address = $request->address;
		$supplier->user_id = Auth::user()->id;

		try{
			$supplier->save();
			$url = session('SOURCE_URL');

	        return redirect()->to($url)->with('message', trans('terms.record-successfully-saved'));
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
		//show a supplier
		$supplier =Supplier::find($id);
		//show the view and pass the $supplier to it
		return view('inventory.supplier.show')->with('supplier', $supplier);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$suppliers = Supplier::find($id);

		//Open the Edit View and pass to it the $patient
		return view('inventory.supplier.edit')->with('suppliers', $suppliers);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SupplierRequest $request, $id)
	{
		$supplier = Supplier::find($id);
		$supplier->name = $request->name;
		$supplier->phone = $request->phone;
		$supplier->email = $request->email;
		$supplier->address = $request->address;
		$supplier->user_id = Auth::user()->id;
		try{
			$supplier->save();
			$url = session('SOURCE_URL');

			return redirect()->to($url)
				->with('message', trans('terms.record-successfully-updated'))
				->with('activesupplier', $supplier->id);
		}catch(QueryException $e){
			Log::error($e);
		}
	}	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the item
		$supplier = Supplier::find($id);
		if(count($supplier->stocks)>0)
		{
			return Redirect::route('supplier.index')->with('message', trans('messages.failure-delete-record'));
		}
		else
		{
			$supplier->delete();
			// redirect
			return Redirect::route('supplier.index')->with('message', trans('messages.record-successfully-deleted'));
		}
	}
}
