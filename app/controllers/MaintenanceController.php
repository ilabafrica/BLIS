<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing Maintenances
 *
 */
class MaintenanceController extends \BaseController {

	/**
	 * Display a listing of the Maintenances.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active Maintenances
			$maintenance = Maintenance::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the Maintenances
		return View::make('maintenance.index')->with('maintenance', $maintenance);
	}

	/**
	 * Show the form for creating a new Maintenance.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		//Create Maintenance view
		return View::make('Maintenance.create')->with('Mai`ntenances');
	}

	/**
	 * Store a newly created Maintenance in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'performed_by' => 'required',
			'instrument' => 'required',
			'reason' => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		// Validate form input
		if ($validator->fails()) {
			return Redirect::route('Maintenance.create')->withErrors($validator);
		} else {
			// Save the Maintenance
			$newMaintenance = new Maintenance();
			$newMaintenance->performed_by = Input::get('performed_by');
			$newMaintenance->instrument = Input::get('instrument');
			$newMaintenance->reason = Input::get('reason');
			$newMaintenance->start = Input::get('start');
			$newMaintenance->end = Input::get('end');

			$newMaintenance->save();
			return Redirect::route('maintenance.index')->with('message', trans('messages.success-creating-Maintenance'));
		}
	}

	/**
	 * Display the specified Maintenance.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show an Maintenance
		$Maintenance = Maintenance::find($id);

		//Show the view and pass the $Maintenance to it
		return View::make('Maintenance.show')->with('Maintenance', $Maintenance);
	}

	/**
	 * Show the form for editing the specified Maintenance.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the Maintenance
		$Maintenance = Maintenance::find($id);

		//Open the Edit View and pass to it the $Maintenance
		return View::make('Maintenance.edit')->with('Maintenance', $Maintenance);
	}

	/**
	 * Update the specified Maintenance.
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
			$Maintenance = Maintenance::find($id);
			$Maintenance->name = Input::get('name');
			$Maintenance->description = Input::get('description');
			$Maintenance->ip = Input::get('ip');
			$Maintenance->hostname = Input::get('hostname');

			try{
				$Maintenance->save();
				$message = trans('messages.success-updating-Maintenance');
			}catch(QueryException $e){
				$message = trans('messages.failure-updating-Maintenance');
				Log::error($e);
			}

			return Redirect::route('Maintenance.index')->with('message', $message);
		}
	}

	/**
	 * Remove the specified Maintenance from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified Maintenances from storage (global UI implementation).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Delete the Maintenance
		$Maintenance = Maintenance::find($id);
 
		$Maintenance->testTypes()->detach();
		$Maintenance->delete();

		// redirect
		return Redirect::route('Maintenance.index')->with('message', trans('messages.success-deleting-Maintenance'));
	}

	/**
	 * Pull test results from an Maintenance as JSON.
	 *
	 * @return Response
	 */
	public function getTestResult()
	{
		//Get Maintenance Interface Class file
		$testTypeID = Input::get("test_type_id");
		$testType = TestType::find($testTypeID);
		$Maintenance = $testType->Maintenances->first();

 		// Fetch the results
		return $Maintenance->fetchResult($testType);
	}

	/**
	 * Pull test results from an Maintenance as JSON. /For controls
	 *
	 * @return Response
	 */
	public function getControlResult()
	{
		$controlID = Input::get("control_id");
		$control = Control::find($controlID);
		$Maintenance = Maintenance::where('name','Celltac F Mek 8222')->first();
 		// Fetch the results
		return $Maintenance->fetchControlResult($control);
	}

	/**
	 * Save an imported implemention of the Intrumentation class.
	 *
	 * @param String route
	 * @return Response
	 */
	public function importDriver()
	{
		$route = (Input::get('import_file') !== null)?Input::get('import_file'):"Maintenance.index";

        $rules = array(
            'import_file' => 'required|max:500'
        );

        $validator = Validator::make(Input::all(), $rules);
        $message = null;

        if ($validator->fails()) {
            return Redirect::route('Maintenance.index')->withErrors($validator);
        } else {
            if (Input::hasFile('import_file')) {
            	$message = Maintenance::saveDriver(Input::file('import_file'));
            }
        }

		return Redirect::route($route)->with('message', $message);
	}
}