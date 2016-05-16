<?php

class BillingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get already set billing settings
		$billing = Billing::first();
		return View::make('billing.index')->with('billing', $billing);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		// Update
		$billing = Billing::find($id);
		$billing->default_currency = Input::get('default_currency');
		$billing->currency_delimiter = Input::get('currency_delimiter');
		$billing->enabled = Input::get('enabled');
		if (Input::hasFile('image'))
		{
            try 
            {
                $extension = Input::file('image')->getClientOriginalExtension();
                $destination = public_path().'/i/';
                $filename = "billing-$id.$extension";

                $file = Input::file('image')->move($destination, $filename);
                $billing->image = "/i/$filename";

            }
            catch (Exception $e) 
            {
                Log::error($e);
            }
        }
		$billing->save();

		// redirect
		$url = Session::get('SOURCE_URL');
        
        return Redirect::to($url)->with('message', trans('messages.record-successfully-updated'));
		
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
