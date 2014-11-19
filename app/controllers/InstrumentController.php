<?php

use Illuminate\Database\QueryException;
// use KBLIS\Instrumentation\;

/**
 *Contains functions for managing instruments
 *
 */
class InstrumentController extends \BaseController {

	/**
	 * Display a listing of the instruments.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active instruments
			$instruments = Instrument::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the instruments
		return View::make('instrument.index')->with('instruments', $instruments);
	}

	/**
	 * Show the form for creating a new instrument.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Get a list of all installed plugins
		$plugins = Instrument::getInstalledPlugins();

		//Create Instrument view
		return View::make('instrument.create')->with('instruments', $plugins);
	}

	/**
	 * Store a newly created instrument in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'instrument' => 'required',
			'ip' => 'required|ip',
		);
		$validator = Validator::make(Input::all(), $rules);

		// Validate form input
		if ($validator->fails()) {
			return Redirect::route('instrument.create')->withErrors($validator);
		} else {
			// Get the instrument

			$plugins = glob(app_path()."/kblis/plugins/*.php");
			$instrument = null;
			$ip = Input::get('ip');

			foreach ($plugins as $plugin) {
				try {
					$className = "KBLIS\\Plugins\\".head(explode(".", last(explode("/", $plugin))));

					// If the instrument code matches that of the select box, WE HAVE A MATCH
					if((new $className($ip))->getEquipmentInfo()['code'] == Input::get('instrument')){
						$instrument = new $className($ip);
						break;	
					}
				} catch (Exception $e) {
					Log::error($e);
				}
			}

			if(isset($instrument)){
				$deviceInfo = $instrument->getEquipmentInfo();

				$newInstrument = new Instrument();
				$newInstrument->name = $deviceInfo['name'];
				$newInstrument->description = $deviceInfo['description'];
				$newInstrument->ip = $ip;
				$newInstrument->hostname = Input::get('hostname');

				try{
					$newInstrument->save();
					$newInstrument->setTestTypes($deviceInfo['testTypes']);
					return Redirect::route('instrument.index')->with('message', trans('messages.success-creating-instrument'));
				}catch(QueryException $e){
					Log::error($e);
				}
			}
			return Redirect::route('instrument.index')->with('message', trans('messages.failure-creating-instrument'));
		}
	}

	/**
	 * Display the specified instrument.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show an instrument
		$instrument = Instrument::find($id);

		//Show the view and pass the $instrument to it
		return View::make('instrument.show')->with('instrument', $instrument);
	}

	/**
	 * Show the form for editing the specified instrument.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the instrument
		$instrument = Instrument::find($id);
		$testtypes = TestType::all();

		//Open the Edit View and pass to it the $instrument
		return View::make('instrument.edit')
					->with('instrument', $instrument)
					->with('testtypes', $testtypes);
	}

	/**
	 * Update the specified instrument.
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
			$instrument = Instrument::find($id);
			$instrument->name = Input::get('name');
			$instrument->description = Input::get('description');
			$instrument->ip = Input::get('ip');
			$instrument->hostname = Input::get('hostname');

			try{
				$instrument->save();
				return Redirect::route('instrument.index')
						->with('message', trans('messages.success-updating-instrument'));
			}catch(QueryException $e){
				Log::error($e);
			}

			return Redirect::route('instrument.index')
						->with('message', trans('messages.failure-updating-instrument'));
		}
	}

	/**
	 * Remove the specified instrument from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified instruments from storage (global UI implementation).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Delete the instrument
		$instrument = Instrument::find($id);
 
		$instrument->testTypes()->detach();
		$instrument->delete();

		// redirect
		return Redirect::route('instrument.index')->with('message', trans('messages.success-deleting-instrument'));
	}

	/**
	 * Pull test results from an instrument as JSON.
	 *
	 * @return Response
	 */
	public function getTestResult()
	{
		//Get Instrument Interface Class file
		$testTypeID = Input::get("test_type_id");
		$testType = TestType::find($testTypeID);
		$instrument = $testType->instruments->first();
		$interfacingClass = $instrument->pivot->interfacing_class;
		$class = "KBLIS\\Instrumentation\\".$interfacingClass;	
 
 		// Invoke the Instrument Interface Class to get the results
		$result = (new $class($instrument->ip))->getResult();


		// Change measure names to measure_ids in the returned array
		$resultWithIDs = array();

		foreach ($result as $measureName => $value) {
			$measureFound = $testType->measures->filter(function($measure) use ($measureName){
				if($measure->name == $measureName) return $measure;
			});

			if(empty($measureFound->toArray())){
				$resultWithIDs[$measureName] = $value;
			}else{
				$resultWithIDs['m_'.$measureFound->first()->id] = $value;
			}
		}

		// Send back a json result
		return json_encode($resultWithIDs);
	}

	/**
	 * Save an imported implemention of the Intrumentation class.
	 *
	 * @param String route
	 * @return Response
	 */
	public function importDriver()
	{
		$route = (Input::get('import_file') !== null)?Input::get('import_file'):"instrument.index";

        $rules = array(
            'import_file' => 'required|max:500'
        );

        $validator = Validator::make(Input::all(), $rules);
        $message = null;

        if ($validator->fails()) {
            return Redirect::route('instrument.index')->withErrors($validator);
        } else {
            if (Input::hasFile('import_file')) {
            	$message = Instrument::saveDriver(Input::file('import_file'));
            }
        }

		return Redirect::route($route)->with('message', $message);
	}
}