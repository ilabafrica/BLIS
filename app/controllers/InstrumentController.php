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
			$i = 0;
			$count = 20000;

			while($i < $count){
				$dumps = ExternalDump::whereRaw("id between $i +1 and $i + 1000")->get();

				foreach ($dumps as $key => $dump) {
					$this->process($dump);
				}
				$i+=1000;
			}

		// // List all the active instruments
		// $instruments = Instrument::paginate(Config::get('kblis.page-items'));

		// // Load the view and pass the instruments
		// return View::make('instrument.index')->with('instruments', $instruments);
	}

	public function process($labRequest)
    {
    	if($labRequest->patient_visit_number == null || $labRequest->result_returned == 1) 
        {
        	return;
        }
        //First: Check if patient exists, if true dont save again
        $patient = Patient::where('patient_number', '=', $labRequest->patient_id)->get();
        
        if ($patient->isEmpty())
        {
            $patient = new Patient();
            $patient->patient_number = $labRequest->patient_id;
            $patient->name = $labRequest->full_name;
            $gender = array('Male' => Patient::MALE, 'Female' => Patient::FEMALE); 
            $patient->gender = $gender[$labRequest->gender];
            $patient->dob = $labRequest->dob;
            $patient->address = $labRequest->address;
            $patient->phone_number = $labRequest->phone_number;
            $patient->save();
        }

        //We check if the test exists in our system if not we just save the request in stagingTable
        if($labRequest->parent_lab_no == '0')
        {
            $testTypeId = TestType::getTestTypeIdByTestName($labRequest->investigation);
        }
        else {
            $testTypeId = null;
        }

        if(is_null($testTypeId) && $labRequest->parent_lab_no == '0')
        {
            return;
        }

        //Check if visit exists, if true dont save again
        $visitCheck = Visit::where('visit_number', '=', $labRequest->patient_visit_number)->get();

        if ($visitCheck->isEmpty())
        {
            $visit = new Visit();
            $visit->patient_id = $patient->id;
            $visitType = array('ip' => 'In-patient', 'op' => 'Out-patient');//Should be a constant
            $visit->visit_type = $visitType[$labRequest->order_stage];
            $visit->visit_number = $labRequest->patient_visit_number;

            // We'll save Visit in a transaction a little bit below
        }

        $test = null;
        //Check if parent_lab_nO is 0 thus its the main test and not a measure
        if($labRequest->parent_lab_no == '0')
        {
            //Check via the labno, if this is a duplicate request and we already saved the test 
            $test = Test::where('external_id', '=', $labRequest->lab_no)->get();
            if ($test->isEmpty())
            {
                //Specimen
                $specimen = new Specimen();
                $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')[0];

                // We'll save the Specimen in a transaction a little bit below

                $test = new Test();
                $test->test_type_id = $testTypeId;
                $test->test_status_id = Test::NOT_RECEIVED;
                $test->created_by = User::EXTERNAL_SYSTEM_USER; //Created by external system 0
                $test->requested_by = $labRequest->requesting_clinician;
                $test->external_id = $labRequest->lab_no;
                $test->time_created = $labRequest->request_date;

                DB::transaction(function() use ($visit, $specimen, $test) {
                    $visit->save();
                    $specimen->save();
                    $test->visit_id = $visit->id;
                    $test->specimen_id = $specimen->id;
                    $test->save();
                });
            }
        }
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
			// Save the instrument
			$code = Input::get('instrument');
			$ip = Input::get('ip');
			$hostname = Input::get('hostname');

			$message = Instrument::saveInstrument($code, $ip, $hostname);

			return Redirect::route('instrument.index')->with('message', $message);
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

		//Open the Edit View and pass to it the $instrument
		return View::make('instrument.edit')->with('instrument', $instrument);
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
				$message = trans('messages.success-updating-instrument');
			}catch(QueryException $e){
				$message = trans('messages.failure-updating-instrument');
				Log::error($e);
			}

			return Redirect::route('instrument.index')->with('message', $message);
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

 		// Fetch the results
		return $instrument->fetchResult($testType);
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