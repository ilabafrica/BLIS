<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Validator;
use App\Models\ControlMeasure;
use App\Models\MeasureType;
use App\Models\ControlMeasureResult;
use App\Models\Instrument;
use App\Models\Control;
use App\Models\ControlTest;
class ControlController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$controls = Control::orderBy('id')->get();
		return view('control.index')->with('controls', $controls);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$instruments = [''=>''] + Instrument::lists('name', 'id')->all();
		$measureTypes = MeasureType::orderBy('id')->take(2)->get();

		return view('control.create')->with('instruments', $instruments)->with('measureTypes', $measureTypes);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation -checking that name is unique among the un soft-deleted ones
		$rules = array('name' => 'required|unique:controls,name,NULL,id,deleted_at,null',
		 			'instrument_id' => 'required',
		 			'new_measures' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return redirect()->to('control.create')->withErrors($validator)->withInput();
		} else {
			// Add
			$control = new Control;
			$control->name = Input::get('name');
			$control->description = Input::get('description');
			$control->instrument_id = Input::get('instrument_id');

			if (Input::get('new_measures')) {
					$newMeasures = Input::get('new_measures');
					$controlMeasure = new ControlMeasureController;
					$controlMeasure->saveMeasuresRanges($newMeasures, $control);
			}
			// redirect
			return redirect()->to('control')
					->with('message', trans('messages.successfully-added-control'))
					->with('activeControl', $control ->id);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$instruments = Instrument::lists('name', 'id');
		$control = Control::find($id);
		$measureTypes = MeasureType::all();
		$instrument = $control->instrument_id;
		return view('control.edit')->with('control', $control)->with('instruments', $instruments)
				->with('measureTypes', $measureTypes)->with('instrument', $instrument);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => 'unique:controls,name,NULL,id,deleted_at,null',
			'instrument_id' => 'required',
			'measures' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			// Update
			$control = Control::find($id);
			$control->name = Input::get('name');
			$control->description = Input::get('description');
			$control->instrument_id = Input::get('instrument_id');

			if (Input::get('new_measures')) {
				$inputNewMeasures = Input::get('new_measures');
				$measures = New ControlMeasureController;
				$measureIds = $measures->saveMeasuresRanges($inputNewMeasures, $control);
			}

			if (Input::get('measures')) {
				$inputMeasures = Input::get('measures');
				$measures = New ControlMeasureController;
				$measures->editMeasuresRanges($inputMeasures, $control);
			}
			// redirect
			return redirect()->back()->with('message', trans('messages.success-updating-control'));
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Delete the control
		$control = Control::find($id);
		$control->delete();
		// redirect
		return redirect()->to('control.index')->with('message', trans('messages.success-deleting-control'));
	}

	/**
	 * Return resultsindex page
	 *
	 * @return Response
	 */
	public function resultsIndex()
	{
		$controls = Control::all();
		return view('control.resultsIndex')->with('controls', $controls);
	}

	/**
	 * Return resultsindex page
	 *
	 * @return Response
	 */
	public function resultsEntry($controlId) 
	{
		$control = Control::find($controlId);
		$lots = Lot::lists('lot_no', 'id');
		return view('control.resultsEntry')->with('control', $control)->with('lots', $lots);
	}

	/**
	 * Return resultshow page
	 *
	 * @return Response
	 */

	public function resultsList($controlId)
	{
		$control = Control::find($controlId);
		return view('control.resultsList')->with('control',$control);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function resultsEdit($controlTestId)
	{
		$controlTest = ControlTest::find($controlTestId);
		$lots = Lot::lists('lot_no', 'id');
		$lot = $controlTest->lot_id;
		return view('control.resultsEdit', compact('controlTest'))->with('lots', $lots)->with('lot', $lot);
	}

	/** 
	* Saves control results
	* 
	* @param Input, result inputs
	* @return Validation errors or response
	*/
	public function saveResults($controlId)
	{
		//Validate
		$control = Control::find($controlId);

		$controlTest = new ControlTest();
		$controlTest->control_id = $controlId;
		$controlTest->lot_id = Input::get('lot_id');
		$controlTest->performed_by = Input::get('performed_by');
		$controlTest->user_id = Auth::user()->id;
		$controlTest->save();

		foreach ($control->controlMeasures as $controlMeasure) {
			$controlResult = new ControlMeasureResult;
			$controlResult->results = Input::get('m_'.$controlMeasure->id);
			$controlResult->control_measure_id = $controlMeasure->id;
			$controlResult->control_test_id = $controlTest->id;
			$controlResult->user_id = Auth::user()->id;
			$controlResult->save();
		}
		return redirect()->to('control.resultsIndex')->with('message', trans('messages.success-adding-control-result'));
	}
}
