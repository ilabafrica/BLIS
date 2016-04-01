<?php

class BarcodeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get variables for use
		$encoding_format = self::keyval(Barcode::ENCODING_FORMAT);
		$barcode_width = self::keyval(Barcode::BARCODE_WIDTH);
		$barcode_height = self::keyval(Barcode::BARCODE_HEIGHT);
		$text_size = self::keyval(Barcode::TEXT_SIZE);
		//	Get already set barcode
		$barcode = Barcode::first();
		return View::make('barcode.index')->with('encoding_format', $encoding_format)->with('barcode_width', $barcode_width)->with('barcode_height', $barcode_height)->with('text_size', $text_size)->with('barcode', $barcode);	
	}

	/**
	 * Display key=>value pair given an array
	 *
	 * @return Response
	 */
	public function keyval($arr)
	{
		$keyval = null;
		foreach ($arr as $value)
		{
			$keyval[$value] = $value;
		}
		return $keyval;
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
		$barcode = Barcode::find($id);
		$barcode->encoding_format = Input::get('encoding_format');
		$barcode->barcode_width = Input::get('barcode_width');
		$barcode->barcode_height = Input::get('barcode_height');
		$barcode->text_size = Input::get('text_size');
		$barcode->save();

		// redirect
		$url = Session::get('SOURCE_URL');
        
        return Redirect::to($url)
			->with('message', trans('messages.barcode-update-success')) ->with('activebarcode', $barcode ->id);
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
