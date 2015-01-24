<?php

    class ImportController {
    /**
	 * Display a listing of the instruments.
	 *
	 * @return Response
	 */
	public function start()
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
        //First: Check if patient exists, if true dont save again
        $patient = Patient::where('patient_number', '=', $labRequest->patient_id)->first();
        
        if (empty($patient))
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
        $visit = Visit::where('visit_number', '=', $labRequest->patient_visit_number)->first();
        if (empty($visit))
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
            $test = Test::where('external_id', '=', $labRequest->lab_no)->first();
            if (empty($test))
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
    }