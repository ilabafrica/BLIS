<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Usage;

class UsageRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->ingnoreId();
		return [
			'stock_id'   => 'required:inv_usage,stock_id,'.$id,
			'request_id'   => 'required:inv_usage,request_id,'.$id,
			'issued_by'   => 'required:inv_usage,issued_by,'.$id,
			'received_by'   => 'required:inv_usage,received_by,'.$id,

        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('stocks.usage');
		$stock_id = $this->input('stock_id');
		$request_id = $this->input('request_id');
		$issued_by = $this->input('issued_by');
		$received_by = $this->input('received_by');
		return Usage::where(compact('stock_id', 'request_id', 'issued_by', 'received_by'))->exists() ? $id : '';
	}
}