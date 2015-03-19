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
		return View::make('supplier.index')->with('suppliers', $suppliers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('supplier.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'name' => 'required|unique:suppliers,name');
		$validator = Validator::make(Input::all(), $rules);

		
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$supplier = new Supplier;
			$supplier->name= Input::get('name');
			$supplier->phone_no= Input::get('phone_no');
			$supplier->email= Input::get('email');
			$supplier->physical_address= Input::get('physical_address');
			try{
				$supplier->save();
				return Redirect::route('supplier.index')
					->with('message',  'Successifully added a new supplier');
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
		//
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
		return View::make('supplier.edit')->with('suppliers', $suppliers);
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

		// process the login
		if ($validator->fails()) {
			return Redirect::to('supplier.edit')->withErrors($validator)->withInput(Input::except('password'));
		} else {
		// Update
			$supplier = Supplier::find($id);
			$supplier->name= Input::get('name');
			$supplier->physical_address= Input::get('physical_address');
			$supplier->phone_no= Input::get('phone_no');
			$supplier->email= Input::get('email');
			$supplier->save();
			try{
				$supplier->save();
				return Redirect::route('supplier.index')
				->with('message', trans('messages.success-updating-supplier')) ->with('activesupplier', $supplier ->id);
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
		$supplier->delete();

		// redirect
		return Redirect::route('supplier.index')->with('message', trans('messages.supplier-succesfully-deleted'));
	}


}
