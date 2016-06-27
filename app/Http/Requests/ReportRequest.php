<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReportRequest extends Request {

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
		// $id = $this->ingnoreId();
		return [];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		// $id = $this->route('role');
		// $name = $this->input('name');
		// return Role::where(compact('id', 'name'))->exists() ? $id : '';
	}
}