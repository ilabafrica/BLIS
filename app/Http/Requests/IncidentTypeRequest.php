<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\IncidentType;
class IncidentTypeRequest extends Request {
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
		return [ 'name' => 'required|unique:incident_types,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('incidenttype');
		$name = $this->input('name');
		return IncidentType::where(compact('id', 'name'))->exists() ? $id : '';
	}
}