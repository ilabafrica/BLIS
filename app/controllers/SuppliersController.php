<?php

class SuppliersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		 $suppliers = Suppliers::orderBy('name', 'ASC')->get();
		return View::make('inventory.suppliersList')->with('suppliers', $suppliers);
		
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('inventory.suppliers');
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
			'suppliers-name' => 'required|unique:inventory_suppliers,name');
		$validator = Validator::make(Input::all(), $rules);

		
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// store
			$supplier = new Suppliers;
			$supplier->name= Input::get('suppliers-name');
			$supplier->phone_no= Input::get('phone-number');
			$supplier->email= Input::get('email');
			$supplier->physical_address= Input::get('physical-address');			
			try{
				$supplier->save();

				return Redirect::route('inventory.suppliersList')
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
		$suppliers = Suppliers::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('inventory.editSuppliers')->with('suppliers', $suppliers);
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
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
		// Update
			$supplier = Suppliers::find($id);
			$supplier->name= Input::get('name');
			$supplier->physical_address= Input::get('physical_address');
			$supplier->phone_no= Input::get('phone_no');
			$supplier->email= Input::get('email');
			$supplier->save();

			$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-updating-supplier')) ->with('activesupplier', $supplier ->id);
          		
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


}
