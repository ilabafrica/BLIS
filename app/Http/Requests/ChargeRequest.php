<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Charge;

class ChargeRequest extends Request {

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
            'test_id'   => 'required|unique:charges,test_id,'.$id,
            'current_amount'   => 'required:charges,test_id,',
        ];
    }
    /**
    * @return \Illuminate\Routing\Route|null|string
    */
    public function ingnoreId(){
        $id = $this->route('charge');
        $test_id = $this->input('test_id');
        return Charge::where(compact('id', 'test_id'))->exists() ? $id : '';
    }

}

