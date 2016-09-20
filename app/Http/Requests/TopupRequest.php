<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Topup;
class TopupRequest extends Request {
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
		return [ 
			'item_id' => 'required:requests,item_id,'.$id,
			'test_category_id' => 'required:requests,test_category_id,'.$id,
			'quantity_ordered' => 'required:requests,quantity_ordered,'.$id,
		];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('control');
		$item_id = $this->input('item_id');
		$test_category_id = $this->input('test_category_id');
		$quantity_ordered = $this->input('quantity_ordered');
		return Topup::where(compact('id', 'item_id', 'test_category_id', 'quantity_ordered'))->exists() ? $id : '';
	}
}
