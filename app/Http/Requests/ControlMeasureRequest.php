<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\ControlMeasure;
class ControlMeasureRequest extends Request {
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
		return [ 'name' => 'required|unique:control_measures,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('controlmeasure');
		$name = $this->input('name');
		$control_id = $this->input('control_id');
		$control_measure_type_id = $this->input('control_measure_type_id');
		return ControlMeasure::where(compact('id', 'name', 'control_id', 'control_measure_type_id'))->exists() ? $id : '';
	}
}
