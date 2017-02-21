<?php namespace App\Http\Controllers;

use App\Models\Barcode;
use Input;
use Session;

// todo: create tests for this class
class BarcodeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

	// Constants for use
		$format = ['ean8', 'ean13', 'code11', 'code39', 'code128', 'codabar', 'std25', 'int25', 'code93'];
		$width = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'];
		$height = ['5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60', '61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72', '73', '74', '75', '76', '77', '78', '79', '80'];
		$font = ['5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39'];
		//	Get variables for use
		$encoding_format = self::keyval($format);
		$barcode_width = self::keyval($width);
		$barcode_height = self::keyval($height);
		$text_size = self::keyval($font);
		//	Get already set barcode
		$barcode = Barcode::first();
		return view('barcode.index')->with('encoding_format', $encoding_format)->with('barcode_width', $barcode_width)->with('barcode_height', $barcode_height)->with('text_size', $text_size)->with('barcode', $barcode);	
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
        
        return redirect()->to($url)
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
