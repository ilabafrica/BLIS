<?php

class RequireVerificationController extends \BaseController {

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit()
	{
		$requireVerification = RequireVerification::get()->first();

		$from = $requireVerification->verification_required_from;
		$to = $requireVerification->verification_required_to;

		$restrictVerification = ($from != $to) ? true : false;

		return View::make('requireverification.edit')
			->with('restrictVerification', $restrictVerification)
			->with('requireVerification', $requireVerification);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$verificationRequired = Input::get('verify');
		$alwaysVerify = Input::get('always');
		$requireVerification = RequireVerification::find(1);
		if ($verificationRequired) {
			if ($alwaysVerify) {

				$from = '00:00:00';
				$to = '00:00:00';
			} else {

				$from = date("H:i", strtotime(Input::get('time_from')));
				$to = date("H:i", strtotime(Input::get('time_to')));
			}
			$requireVerification->verification_required_from = $from;
			$requireVerification->verification_required_to = $to;
		}
		$requireVerification->verification_required = $verificationRequired;
		$requireVerification->save();

		return Redirect::route('requireverification.edit')
			->with('message', trans('messages.success-updating-verification-config'));
	}

}