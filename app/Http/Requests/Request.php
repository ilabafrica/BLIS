<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
	/**
	 * {@inheritdoc}
	 */
	protected function formatErrors(Validator $validator)
	{
		// Priceless for troublshooting failing store and update when tests fail. uncomment dd();
		// see what it says
		// dd($validator->errors()->all());
		return $validator->errors()->all();
	}
}
