<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Permission;
class PermissionRequest extends Request {
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
		return [ 'name' => 'required|unique:permissions,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('permission');
		$name = $this->input('name');
		$display_name = $this->input('display_name');
		return Permission::where(compact('id', 'name', 'display_name'))->exists() ? $id : '';
	}
}
