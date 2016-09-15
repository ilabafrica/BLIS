<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Critical;

class CriticalRequest extends Request {

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
			'measure_id' => 'required:critical,parameter,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('critical');
		$parameter = $this->input('measure_id');
		return Critical::where(compact('id', 'parameter'))->exists() ? $id : '';
	}
}
