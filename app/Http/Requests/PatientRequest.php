<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Patient;

class PatientRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->ingnoreId();
		return [
			'patient_number' => 'required|unique:patients,patient_number,'.$id,
            'name'   => 'required:patients,name,'.$id,
            'gender'   => 'required:patients,gender,'.$id,
            'dob'   => 'required:patients,dob,'.$id,
            'address'   => 'required:patients,address,'.$id
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('patient');
		$name = $this->input('name');
		return Patient::where(compact('id', 'name'))->exists() ? $id : '';
	}
}