<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\ControlMeasureResult;
class ControlResultsRequest extends Request {
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
		return [ 'name' => 'required|unique:control_results,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('controlresults');
		$control_measure_id = $this->input('control_measure_id');
		$control_test_id = $this->input('control_test_id');
		return ControlMeasureResult::where(compact('id', 'control_measure_id', 'control_test_id'))->exists() ? $id : '';
	}
}
