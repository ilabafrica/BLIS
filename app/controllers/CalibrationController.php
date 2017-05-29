<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing Calibrations
 *
 */
class CalibrationController extends \BaseController {

	/**
	 * Display a listing of the Calibrations.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active Calibrations
			$calibrations = Calibration::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the Calibrations
		return View::make('calibration.index')->with('calibrations', $calibrations);
	}

	/**
	 * Show the form for creating a new Calibration.
	 *
	 * @return Response
	 */
	public function create()
	{
	

		//Create Calibration view
		return View::make('Calibration.create')->with('Calibrations');
	}

	/**
	 * Store a newly created Calibration in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'name' => 'required',
			'description' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// Validate form input
		if ($validator->fails()) {
			return Redirect::route('Calibration.create')->withErrors($validator);
		} else {
			// Save the Calibration
			$newCalibration = new Calibration();
			$newCalibration->name = Input::get('name');
			$newCalibration->description = Input::get('description');
			
			$newCalibration->save();
			return Redirect::route('calibration.index')->with('message', trans('messages.success-creating-Calibration'));
		}
	}

	/**
	 * Display the specified Calibration.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show an Calibration
		$Calibration = Calibration::find($id);

		//Show the view and pass the $Calibration to it
		return View::make('Calibration.show')->with('Calibration', $Calibration);
	}

	/**
	 * Show the form for editing the specified Calibration.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the Calibration
		$Calibration = Calibration::find($id);

		//Open the Edit View and pass to it the $Calibration
		return View::make('Calibration.edit')->with('Calibration', $Calibration);
	}

	/**
	 * Update the specified Calibration.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$rules = array(
			'name' => 'required',
			'ip' => 'required|ip'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$Calibration = Calibration::find($id);
			$Calibration->name = Input::get('name');
			$Calibration->description = Input::get('description');
			$Calibration->ip = Input::get('ip');
			$Calibration->hostname = Input::get('hostname');

			try{
				$Calibration->save();
				$message = trans('messages.success-updating-Calibration');
			}catch(QueryException $e){
				$message = trans('messages.failure-updating-Calibration');
				Log::error($e);
			}

			return Redirect::route('Calibration.index')->with('message', $message);
		}
	}

	/**
	 * Remove the specified Calibration from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified Calibrations from storage (global UI implementation).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Delete the Calibration
		$Calibration = Calibration::find($id);
 
		$Calibration->testTypes()->detach();
		$Calibration->delete();

		// redirect
		return Redirect::route('Calibration.index')->with('message', trans('messages.success-deleting-Calibration'));
	}

	/**
	 * Pull test results from an Calibration as JSON.
	 *
	 * @return Response
	 */
	public function getTestResult()
	{
		//Get Calibration Interface Class file
		$testTypeID = Input::get("test_type_id");
		$testType = TestType::find($testTypeID);
		$Calibration = $testType->Calibrations->first();

 		// Fetch the results
		return $Calibration->fetchResult($testType);
	}

	/**
	 * Pull test results from an Calibration as JSON. /For controls
	 *
	 * @return Response
	 */
	public function getControlResult()
	{
		$controlID = Input::get("control_id");
		$control = Control::find($controlID);
		$Calibration = Calibration::where('name','Celltac F Mek 8222')->first();
 		// Fetch the results
		return $Calibration->fetchControlResult($control);
	}

	/**
	 * Save an imported implemention of the Intrumentation class.
	 *
	 * @param String route
	 * @return Response
	 */
	public function importDriver()
	{
		$route = (Input::get('import_file') !== null)?Input::get('import_file'):"Calibration.index";

        $rules = array(
            'import_file' => 'required|max:500'
        );

        $validator = Validator::make(Input::all(), $rules);
        $message = null;

        if ($validator->fails()) {
            return Redirect::route('Calibration.index')->withErrors($validator);
        } else {
            if (Input::hasFile('import_file')) {
            	$message = Calibration::saveDriver(Input::file('import_file'));
            }
        }

		return Redirect::route($route)->with('message', $message);
	}
}