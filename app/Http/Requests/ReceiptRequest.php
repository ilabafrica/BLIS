<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Receipt;
class ReceiptRequest extends Request {
	/**
	* Determine if the user is authorized to make this request.
	*
	* @return bool
	*/
	public function authorize() {
		return true;
	}
	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules() {
		$id = $this->ingnoreId();
		return [ 'name' => 'required|unique:receipts,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('receipt');
		$commodity_id = $this->input('commodity_id');
		$supplier_id = $this->input('supplier_id');
		$user_id = $this->input('user_id');
		return Receipt::where(compact('id', 'commodity_id', 'supplier_id', 'user_id'))->exists() ? $id : '';
	}
}
