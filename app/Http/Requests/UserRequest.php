<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;

class UserRequest extends Request {

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
            'name'   => 'required|unique:users,name,'.$id,
            'gender'   => 'required:users,gender,'.$id,
            'email'   => 'unique:users,email,'.$id,
            'phone'   => 'required|unique:users,phone,'.$id,
            'username'   => 'required|unique:users,username,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('user');
		$name = $this->input('name');
		$email = $this->input('email');
		return User::where(compact('id', 'name', 'email'))->exists() ? $id : '';
	}
}