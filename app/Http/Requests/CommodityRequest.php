<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Commodity;
class CommodityRequest extends Request {
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
		return [ 'name' => 'required|unique:commodities,name,'.$id, ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('commodity');
		$name = $this->input('name');
		$metric_id = $this->input('metric_id');
		return Commodity::where(compact('id', 'name', 'metric_id'))->exists() ? $id : '';
	}
}
