<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Issue;
class IssueRequest extends Request {
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
		return [ 'name' => 'required|unique:issues,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('issue');
		$receipt_id = $this->input('receipt_id');
		$topup_request_id = $this->input('topup_request_id');
		$user_id = $this->input('user_id');
		return Issue::where(compact('id', 'receipt_id', 'topup_request_id', 'user_id'))->exists() ? $id : '';
	}
}
