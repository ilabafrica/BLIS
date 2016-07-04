<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Incident;
class IncidentRequest extends Request {
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
			'incident_date' => 'required:incidents,incident_date,'.$id, 
			'scene' => 'required:incidents,scene,'.$id, 
			'victim' => 'required:incidents,victim,'.$id, 
			'incident_type' => 'required:incidents,incident_type,'.$id, 
			'equipment_code' => 'required:incidents,equipment_code,'.$id, 
			'sop' => 'required:incidents,sop,'.$id,
			'description' => 'required:incidents,description,'.$id,
			'first_aid' => 'required:incidents,first_aid,'.$id,
			'corrective_action' => 'required:incidents,corrective_action,'.$id,
			'reporting_officer' => 'required:incidents,reporting_officer,'.$id,
		];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('incident');
		$incident_date = $this->input('incident_date');
		$scene = $this->input('scene');
		$victim = $this->input('victim');
		$incident_type = $this->input('incident_type');
		$equipment_code = $this->input('equipment_code');
		$sop = $this->input('sop');
		$description = $this->input('description');
		$first_aid = $this->input('first_aid');
		$corrective_action = $this->input('corrective_action');
		$reporting_officer = $this->input('reporting_officer');
		return Incident::where(compact('id', 'incident_date', 'scene', 'victim', 'incident_type', 'equipment_code', 'sop', 'description', 'first_aid', 'corrective_action', 'reporting_officer'))->exists() ? $id : '';
	}
}