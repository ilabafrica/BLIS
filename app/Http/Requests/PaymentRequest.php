<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Payment;

class PaymentRequest extends Request {

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
            'patient_id'   => 'required,'.$id,
            'charge_id'   => 'required,'.$id,
            'full_amount'   => 'required,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('payment');
		$patient_id = $this->input('patient_id');
		$charge_id = $this->input('charge_id');
		$full_amount = $this->input('full_amount');
		return Payment::where(compact('id', 'test_id'))->exists() ? $id : '';
	}

}
