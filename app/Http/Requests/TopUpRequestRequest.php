<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\TopupRequest;
class TopUpRequestRequest extends Request {
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
		return [ 'name' => 'required|unique:topup_requests,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('topup');
		$commodity_id = $this->input('commodity_id');
		$test_category_id = $this->input('test_category_id');
		$user_id = $this->input('user_id');
		return TopupRequest::where(compact('id', 'commodity_id', 'test_category_id', 'user_id'))->exists() ? $id : '';
	}
}
