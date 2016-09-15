<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Usage;

class UsageRequest extends Request {

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
            'stock_id'   => 'required:inv_usage,stock_id,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('stocks.usage');
		$stock_id = $this->input('stock_id');
		return Usage::where(compact('stock_id'))->exists() ? $id : '';
	}
}