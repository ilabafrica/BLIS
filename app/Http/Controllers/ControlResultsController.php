<?php namespace App\Http\Controllers;

use Auth;
use Input;

use App\Models\ControlTest;
use App\Models\ControlMeasureResult;
use App\Models\Control;
class ControlResultsController extends Controller {

	


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($controlTestId) 
	{
		$control = Control::find($controlTestId);
		$controlTest = ControlTest::find($controlTestId);    
		$controlTest->entered_by = Auth::user()->id;
		$controlTest->control_id = $controlTest->control->id;
		$controlTest->save();

		foreach ($controlTest->control->controlMeasures as $controlMeasure) {
			$controlResult = ControlMeasureResult::where('control_measure_id', $controlMeasure->id)->where('control_test_id', $controlTest->id)->first();
			$controlResult->results = Input::get('m_'.$controlMeasure->id);
			$controlResult->control_measure_id = $controlMeasure->id;
			$controlResult->control_test_id = $controlTestId;
			$controlResult->save();
		}
		return redirect()->to('control.resultsIndex')->with('message', trans('messages.success-updating-control-result'));
	}



}
