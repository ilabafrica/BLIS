<?php namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Commodity;
use App\Models\Supplier;
use Validator;

use Input;
use Auth;
class ReceiptController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$receipts = Receipt::all();
		return view('receipt.index')->with('receipts', $receipts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$commodities = Commodity::lists('name', 'id');
		$suppliers = Supplier::lists('name', 'id');
		return view('receipt.create')
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'commodity' => 'required',
			'quantity' => 'required',
			'batch_no' => 'required',
			'supplier' => 'required',
			'expiry_date' => 'required|date'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return redirect()->to('receipt.index')->withErrors($validator);
				
		} else {
			$receipts = new Receipt;
			$receipts->commodity_id = Input::get('commodity');
			$receipts->supplier_id = Input::get('supplier');
			$receipts->quantity = Input::get('quantity');
			$receipts->batch_no = Input::get('batch_no');
			$receipts->expiry_date= Input::get('expiry_date');
			// todo: is this column neccessary ... it's not in the migrations
			// $receipts->user_id= Auth::user()->id;

			$receipts->save();
			return redirect()->to('receipt.index')
					->with('message', trans('messages.receipt-succesfully-added'));
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
		$receipt = Receipt::find($id);
		$suppliers = Supplier::all()->lists('name', 'id');
		$commodities = Commodity::all()->lists('name', 'id');

		return view('receipt.edit')
				->with('receipt', $receipt)
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'commodity' => 'required',
		
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return redirect()->to('receipt.index')->withErrors($validator);
				
		} else {
			// Update
			$receipt = Receipt::find($id);
			$receipt->commodity_id = Input::get('commodity');
			$receipt->supplier_id = Input::get('supplier');
			$receipt->quantity = Input::get('quantity');
			$receipt->batch_no = Input::get('batch_no');
			$receipt->expiry_date= Input::get('expiry_date');
				
		    $receipt->save();
			return redirect()->to('receipt.index')
					->with('message', trans('messages.receipt-succesfully-updated'));
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
		//Soft delete the patient
		$receipt = Receipt::find($id);
		$receipt->delete();

		// redirect
		return redirect()->to('receipt.index')
			->with('message', trans('messages.receipt-succesfully-deleted'));
	}


}
