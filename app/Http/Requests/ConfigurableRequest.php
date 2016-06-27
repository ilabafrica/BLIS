<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Configurable;

class ConfigurableRequest extends Request {

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
            'name'   => 'required|unique:configurables,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('configurable');
		$name = $this->input('name');
		return Configurable::where(compact('id', 'name'))->exists() ? $id : '';
	}
}