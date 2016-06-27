<?php namespace App\Http\Controllers;

use Auth;
use Input;
use Validator;
use App\Models\ControlMeasure;
use App\Models\MeasureType;
use App\Models\ControlMeasureResult;
use App\Models\Lot;
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
		$lots = [''=>''] + Lot::lists('number', 'id')->all();
		$measureTypes = MeasureType::orderBy('id')->take(2)->get();

		return view('control.create')->with('lots', $lots)->with('measureTypes', $measureTypes);
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
		 			'lot' => 'required|non_zero_key',
		 			'new-measures' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return redirect()->to('control.create')->withErrors($validator)->withInput();
		} else {
			// Add
			$control = new Control;
			$control->name = Input::get('name');
			$control->description = Input::get('description');
			$control->lot_id = Input::get('lot');

			if (Input::get('new-measures')) {
					$newMeasures = Input::get('new-measures');
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
		$lots = Lot::lists('number', 'id');
		$control = Control::find($id);
		$measureTypes = MeasureType::all();
		return view('control.edit')->with('control',$control)->with('lots', $lots)
				->with('measureTypes', $measureTypes);
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
			'lot' => 'required|non_zero_key',
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
			$control->lot_id = Input::get('lot');

			if (Input::get('new-measures')) {
				$inputNewMeasures = Input::get('new-measures');
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
		return view('control.resultsEntry')->with('control', $control);
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
		return view('control.resultsEdit', compact('controlTest'));
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
		$controlTest->entered_by = Auth::user()->id;
		$controlTest->control_id = $controlId;
		$controlTest->save();

		foreach ($control->controlMeasures as $controlMeasure) {
			$controlResult = new ControlMeasureResult;
			$controlResult->results = Input::get('m_'.$controlMeasure->id);
			$controlResult->control_measure_id = $controlMeasure->id;
			$controlResult->control_test_id = $controlTest->id;
			$controlResult->save();
		}
		return redirect()->to('control.resultsIndex')->with('message', trans('messages.success-adding-control-result'));
	}
}
