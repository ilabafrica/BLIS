<?php

class ControlResultsController extends \BaseController {

	


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($controlId) 
	{
		//Validate
		$control = Control::find($controlId);

		$controlTest = ControlTest::find($controlId);
		$controlTest->entered_by = Auth::user()->id;
		$controlTest->control_id = $controlId;
		$controlTest->save();

		foreach ($control->controlMeasures as $controlMeasure) {
			$controlResult = ControlMeasureResult::find($controlId);
			$controlResult->results = Input::get('m_'.$controlMeasure->id);
			$controlResult->control_measure_id = $controlMeasure->id;
			$controlResult->control_test_id = $controlTest->id;
			$controlResult->save();
		}
		return Redirect::route('control.resultsIndex')->with('message', trans('messages.success-updating-control-result'));
	}



}
