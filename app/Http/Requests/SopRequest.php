<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Sop;

class SopRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		// dd('am in request authorize');
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		// dd('am in request rules');
		$id = $this->ingnoreId();
		// dd($id);
		return [
            'name'   => 'required|unique:sops,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		// dd('am in request ingnoreId');
		$id = $this->route('sop');
		$name = $this->input('name');
		return Sop::where(compact('id', 'name'))->exists() ? $id : '';
	}
}