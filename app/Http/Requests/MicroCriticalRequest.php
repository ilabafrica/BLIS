<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\MicroCritical;

class MicroCriticalRequest extends Request {

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
			'description' => 'required|unique:micro_critical,description,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('microcritical');
		$description = $this->input('description');
		return MicroCritical::where(compact('id', 'description'))->exists() ? $id : '';
	}
}