<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Control;
class ControlRequest extends Request {
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
		return [ 'name' => 'required|unique:controls,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('control');
		$name = $this->input('name');
		$lot_id = $this->input('lot_id');
		return Control::where(compact('id', 'name', 'lot_id'))->exists() ? $id : '';
	}
}
