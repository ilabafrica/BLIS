<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Stock;

class StockRequest extends Request {

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
            'item_id'   => 'required:inv_supply,item_id,'.$id,
            'supplier_id'   => 'required:inv_supply,supplier_id,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('stock');
		$item_id = $this->input('item_id');
		$supplier_id = $this->input('supplier_id');
		return Stock::where(compact('id', 'item_id', 'supplier_id'))->exists() ? $id : '';
	}
}