<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TestType;

class TestTypeRequest extends Request {

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
            'name'   => 'required|unique:test_types,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('testtype');
		$name = $this->input('name');
		return TestType::where(compact('id', 'name'))->exists() ? $id : '';
	}
}