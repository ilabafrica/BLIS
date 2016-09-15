<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Measure;
class MeasureRequest extends Request {
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
		return [ 'name' => 'required|unique:measures,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('measure');
		$measure_type_id = $this->input('measure_type_id');
		$name = $this->input('name');
		return Measure::where(compact('id', 'measure_type_id', 'name'))->exists() ? $id : '';
	}
}
