<?php

class SupplierController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		 $suppliers = Supplier::orderBy('name', 'ASC')->get();
		return View::make('inventory.supplier.index')->with('suppliers', $suppliers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inventory.supplier.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name' => 'required|unique:suppliers,name');
		$validator = Validator::make(Input::all(), $rules);

		
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->WithInput();
		} else {
			// store
			$supplier = new Supplier;
			$supplier->name= Input::get('name');
			$supplier->phone= Input::get('phone');
			$supplier->email= Input::get('email');
			$supplier->address= Input::get('address');
			$supplier->user_id = Auth::user()->id;
			try{
				$supplier->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message',  trans('messages.record-successfully-saved'));
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
		//show a supplier
		$supplier =Supplier::find($id);
		//show the view and pass the $supplier to it
		return View::make('inventory.supplier.show')->with('supplier', $supplier);
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
		return View::make('inventory.supplier.edit')->with('suppliers', $suppliers);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{//Validate
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the request
		if ($validator->fails()) {
			return Redirect::to('inventory.supplier.edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
		// Update
			$supplier = Supplier::find($id);
			$supplier->name= Input::get('name');
			$supplier->address= Input::get('address');
			$supplier->phone= Input::get('phone');
			$supplier->email= Input::get('email');
			$supplier->user_id = Auth::user()->id;
			$supplier->save();
			try{
				$supplier->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activesupplier', $supplier ->id);
			}catch(QueryException $e){
				Log::error($e);
			}
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
