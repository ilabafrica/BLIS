<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Facility;

class FacilityRequest extends Request {

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
            'name'   => 'required|unique:facilities,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('facility');
		$name = $this->input('name');
		return Facility::where(compact('id', 'name'))->exists() ? $id : '';
	}
}