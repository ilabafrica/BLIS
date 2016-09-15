<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\RejectionReason;
class SpecimenRejectionRequest extends Request {
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
		return [ 'name' => 'required|unique:rejection_reasons,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('specimenrejection');
		$reason = $this->input('reason');
		return RejectionReason::where(compact('id', 'reason'))->exists() ? $id : '';
	}
}
