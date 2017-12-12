<?php

class SanitasInterfacer implements InterfacerInterface{

    public function retrieve($labRequest)
    {
        //In sanitas case request are sent to us thus not much to do here
        //validate input
        //Check if json
        $this->process($labRequest);
    }

    /**
    * Process Sends results back to the originating system
    *   Send is the main entry point into the interfacer
    *   We process and send the current testID and also try and resend tests that have failed to send.
    */
    public function send($testId)
    {
        //Sending current test

        $this->createJsonString($testId);
        //Sending all pending requests also
        $pendingRequests = ExternalDump::where('result_returned', 2)->get();
        // if(!$pendingRequests->isEmpty()){
        //     foreach ($pendingRequests as $pendingRequest) {
        //         $this->createJsonString($pendingRequest->test_id);
        //     }
        // }
    }


    /**
    * Retrieves the results and creates a JSON string
    *
    * @param testId the id of the test to send
    * @param 
    */
    public function createJsonString($testId)
    {
        //if($comments==null or $comments==''){$comments = 'No Comments';

        //We use curl to send the requests
        $httpCurl = curl_init(Config::get('kblis.sanitas-url'));
        curl_setopt($httpCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($httpCurl, CURLOPT_POST, true);

        //If testID is null we cannot handle this test as we cannot know the results
        if($testId == null){
            return null;
        }

        //Get the test and results 
        $test = Test::find($testId);
        $testResults = $test->testResults;

        //Measures
        $testTypeId = $test->testType()->get()->lists('id')[0];
        $testType = TestType::find($testTypeId);
        $testMeasures = $testType->measures;

        //Get external requests and all its children
        $externalDump = new ExternalDump();
        $externRequest = ExternalDump::where('test_id', '=', $testId)->get();

        if(!($externRequest->first())){
            //Not a request we can send back
            return null;
        }

        $labNo = $externRequest->lists('lab_no')[0];
        $externlabRequestTree = $externalDump->getLabRequestAndMeasures($labNo);

        $interpretation = "";
        //IF the test has no children prepend the status to the result
        if ($externlabRequestTree->isEmpty()) {
            if($test->test_status_id == Test::COMPLETED){
                $interpretation = "Done: ".$test->interpretation;
            }
            elseif ($test->test_status_id == Test::VERIFIED) {
                $interpretation = "Tested and verified: ".$test->interpretation;
            }
        }
        //IF the test has children, prepend the status to the interpretation
        else {
            if($test->test_status_id == Test::COMPLETED){
                $interpretation = "Done ".$test->interpretation;
            }
            elseif ($test->test_status_id == Test::VERIFIED) {
                $interpretation = "Tested and verified ".$test->interpretation;
            }
        }

        //TestedBy
        $tested_by = ExternalUser::where('internal_user_id', '=', $test->tested_by)->get()->first();

        if($tested_by == null){
            $tested_by = "59";
        }
        else if ($tested_by->external_user_id == null){
            $tested_by = "59";
        }
        else{
             $tested_by = $tested_by->external_user_id;
        }

        if($test->verified_by == 0 || $test->verified_by == null){
            $verified_by = "59";
        }
        else {
            $verified_by = ExternalUser::where('internal_user_id', '=', $test->verified_by)->get()->first();

            if($verified_by == null){
                $verified_by = "59";
            }
            else if ($verified_by->external_user_id == null){
                $verified_by = "59";
            }
            else {
                $verified_by = $verified_by->external_user_id;
            }
        }

        //TODO - relate measure to test-result
        $range = Measure::getRange($test->visit->patient, $testResults->first()->measure_id);
        $unit = Measure::find($testResults->first()->measure_id)->unit;

        $result = $testResults->first()->result ." ". $range ." ".$unit;

        $jsonResponseString = sprintf('{"labNo": "%s","requestingClinician": "%s", "result": "%s", "verifiedby": "%s", "techniciancomment": "%s"}', 
            $labNo, $tested_by, $result, $verified_by, trim($interpretation));
        $this->sendRequest($httpCurl, urlencode($jsonResponseString), $labNo);
        
        //loop through labRequests and foreach of them get the result and put in an array
        foreach ($externlabRequestTree as $key => $externlabRequest){ 
            $mKey = array_search($externlabRequest->investigation, $testMeasures->lists('name'));
            
            if($mKey === false){
                Log::error("MEASURE NOT FOUND: Measure $externlabRequest->investigation not found in our system");
            }
            else {
                $measureId = $testMeasures->get($mKey)->id;

                $rKey = array_search($measureId, $testResults->lists('measure_id'));
                $matchingResult = $testResults->get($rKey);

                $range = Measure::getRange($test->visit->patient, $measureId);
                $unit = Measure::find($measureId)->unit;

                $result = $matchingResult->result." ". $range ." ".$unit;

                $jsonResponseString = sprintf('{"labNo": "%s","requestingClinician": "%s", "result": "%s", "verifiedby": "%s", "techniciancomment": "%s"}', 
                            $externlabRequest->lab_no, $tested_by, $result, $verified_by, "");
                $this->sendRequest($httpCurl, urlencode($jsonResponseString), $externlabRequest->lab_no);
            }
        }
        curl_close($httpCurl);
    }

    /**
    *   Function to send Json request using Curl
    **/

    private function sendRequest($httpCurl, $jsonResponse, $labNo)
    {
        $jsonResponse = "labResult=".$jsonResponse;
        //Foreach result in the array of results send to sanitas-url in config
        curl_setopt($httpCurl, CURLOPT_POSTFIELDS, $jsonResponse);

        $response = curl_exec($httpCurl);

        //"Test updated" is the actual response 
        //TODO: Replace true with actual expected response this is just for testing
        if($response == "Test updated")
        {
            //Set status in external lab-request to `sent`
            $updatedExternalRequest = ExternalDump::where('lab_no', '=', $labNo)->first();
            $updatedExternalRequest->result_returned = 1;
            $updatedExternalRequest->save();
        }
        else
        {
            //Set status in external lab-request to `sent`
            $updatedExternalRequest = ExternalDump::where('lab_no', '=', $labNo)->first();
            $updatedExternalRequest->result_returned = 2;
            $updatedExternalRequest->save();
            Log::error("HTTP Error: SanitasInterfacer failed to send $jsonResponse : Error message "+ curl_error($httpCurl));
        }
    }

     /**
     * Function for processing the requests we receive from the external system
     * and putting the data into our system.
     *
     * @var array lab_requests
     */
    public function process($labRequest)
    {
        //First: Check if patient exists, if true dont save again
        $patient = Patient::where('external_patient_number', '=', $labRequest->patient->id)->where('name', '=', $labRequest->patient->fullName)->get();

        if (!$patient->first())
        {
            $patient = new Patient();
            $patient->external_patient_number = $labRequest->patient->id;
            $patient->patient_number = $labRequest->patient->id;
            $patient->name = $labRequest->patient->fullName;
            $gender = array('Male' => Patient::MALE, 'Female' => Patient::FEMALE); 
            
            $patient->gender = $gender[$labRequest->patient->gender];

            $patient->dob = $labRequest->patient->dateOfBirth;
            $patient->address = $labRequest->address->address;
            $patient->phone_number = $labRequest->address->phoneNumber;
            $patient->created_by = User::EXTERNAL_SYSTEM_USER;
            $patient->save();
        }
        else{
            $patient = $patient->first();
        }

//        //We check if the test exists in our system if not we just save the request in stagingTable
        if($labRequest->parentLabNo == '0' || $this->isPanelTest($labRequest))
        {
            $testTypeId = TestType::getTestTypeIdByTestName($labRequest->investigation);
        }
        else {
            $testTypeId = null;
        }
        if(is_null($testTypeId) && $labRequest->parentLabNo == '0')
        {
            $this->saveToExternalDump($labRequest, ExternalDump::TEST_NOT_FOUND);
            return;
        }
        //Check if visit exists, if true dont save again
        $visitType = array('ip' => 'In-patient', 'op' => 'Out-patient');//Should be a constant
        $visit = Visit::where('visit_number', '=', $labRequest->patientVisitNumber)->where('visit_type', '=', $visitType[$labRequest->orderStage])->where('patient_id', '=', $patient->id)->get();
        if (!$visit->first())
        {
            $visit = new Visit();
            $visit->patient_id = $patient->id;
            $visit->visit_type = $visitType[$labRequest->orderStage];
            $visit->visit_number = $labRequest->patientVisitNumber;

            // We'll save Visit in a transaction a little bit below
        }
        else{
            $visit = $visit->first();
            if(strcmp($visitType[$labRequest->orderStage], $visit->visit_type) !=0)
            {
                $visit = new Visit();
                $visit->patient_id = $patient->id;
                $visit->visit_type = $visitType[$labRequest->orderStage];
                $visit->visit_number = $labRequest->patientVisitNumber;
            }
        }

        $test = null;
        //Check if parentLabNO is 0 thus its the main test and not a measure
        if($labRequest->parentLabNo == '0' || $this->isPanelTest($labRequest))
        {
            //Check via the labno, if this is a duplicate request and we already saved the test

            $test = Test::where('external_id', '=', $labRequest->labNo)->orderby('time_created', 'desc')->get();
            if (!$test->first() || $test->first()->visit->patient_id != $patient->id)
            {
                //Specimen
                $specimen = new Specimen();
                $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')[0];

                // We'll save the Specimen in a transaction a little bit below
                $test = new Test();
                $test->test_type_id = $testTypeId;
                $test->test_status_id = Test::NOT_RECEIVED;
                $test->created_by = User::EXTERNAL_SYSTEM_USER; //Created by external system 0
                $test->requested_by = $labRequest->requestingClinician;
                $test->external_id = $labRequest->labNo;

                DB::transaction(function() use ($visit, $specimen, $test) {
                    $visit->save();
                    $specimen->save();
                    $test->visit_id = $visit->id;
                    $test->specimen_id = $specimen->id;
                    $test->save();
                });

                $this->saveToExternalDump($labRequest, $test->id);
                return;
            }
        }
        $this->saveToExternalDump($labRequest, null);
    }

    /**
    * Function for saving the data to externalDump table
    * 
    * @param $labrequest the labrequest in array format
    * @param $testId the testID to save with the labRequest or 0 if we do not have the test
    *        in our systems.
    */
    public function saveToExternalDump($labRequest, $testId)
    {
        //Dumping all the received requests to stagingTable
        $dumper = ExternalDump::firstOrNew(array('lab_no' => $labRequest->labNo));
        $dumper->lab_no = $labRequest->labNo;
        $dumper->parent_lab_no = $labRequest->parentLabNo;
        if($dumper->test_id == null){
            $dumper->test_id = $testId;
        }
        else if($dumper->test_id != null && $testId != null && $dumper->test_id != $testId){
            $dumper->test_id = $testId;
        }
        $dumper->requesting_clinician = $labRequest->requestingClinician;
        $dumper->investigation = $labRequest->investigation;
        $dumper->provisional_diagnosis = '';
        $dumper->request_date = $labRequest->requestDate;
        $dumper->order_stage = $labRequest->orderStage;
        $dumper->patient_visit_number = $labRequest->patientVisitNumber;
        $dumper->patient_id = $labRequest->patient->id;
        $dumper->full_name = $labRequest->patient->fullName;
        $dumper->dob = $labRequest->patient->dateOfBirth;
        $dumper->gender = $labRequest->patient->gender;
        $dumper->address = $labRequest->address->address;
        $dumper->postal_code = '';
        $dumper->phone_number = $labRequest->address->phoneNumber;
        $dumper->city = $labRequest->address->city;
        $dumper->cost = $labRequest->cost;
        $dumper->receipt_number = $labRequest->receiptNumber;
        $dumper->receipt_type = $labRequest->receiptType;
        $dumper->waiver_no = '';
        $dumper->system_id = "sanitas";
        $dumper->save();
    }

    public function isPanelTest($labRequest)
    {
        //If parent is panel test
        if($labRequest->parentLabNo != '0'){
//            dd(ExternalDump::orderBy('id', 'desc')->first());
            $parent = ExternalDump::where('lab_no', $labRequest->parentLabNo)->first();
            $panel = $this->getPanelByName($parent->investigation);
            if (isset($panel)) {
                //If is one of the child test of panel
                foreach ($panel->testTypes as $testType) {
                    if($testType->name == $labRequest->investigation) {
                        return true;
                    }
                }
            }
        }
    }

    public function getPanelByName($investigation)
    {
        $panelName = trim($investigation);
        $panel = Panel::where('name', 'like', $panelName)->where('active', 1)->orderBy('name')->first();
        return $panel;
    }
}
