<?php namespace Api;

class MedbossInterfacer implements InterfacerInterface {

    public function retrieve($patientId)
    {
        //Setup mssql connection
        $connection = $this->connectToMedboss();

        $labRequests = mssql_query("SELECT * FROM $this->labRequestView WHERE (PatientNumber='$patientId')", $connection);
        
        while($patientData = mssql_fetch_object($labRequests, $connection))
        {
            //save received data in staging table and to internal tables
            $this->process($patientData);
        }
    }

    public function process($labRequest)
    {
        //First: Check if patient exists, if true dont save again
        $patient = Patient::where('external_patient_number', '=', $labRequest->PatientNumber)->get();
        
        if (!$patient->first())
        {
            $patient = new Patient();
            $patient->external_patient_number = $labRequest->PatientNumber;
            $patient->patient_number = $labRequest->PatientNumber;
            $patient->name = $labRequest->FullNames;
            $gender = array('M' => Patient::MALE, 'F' => Patient::FEMALE, 'U' => Patient::UNKNOWN); 
            $patient->gender = $gender[$labRequest->Sex];
            $patient->dob = $this->getDobFromAge($labRequest->Age);
            $patient->address = $labRequest->PoBox;
            $patient->phone_number = $labRequest->PatientsContact;
            $patient->created_by = User::EXTERNAL_SYSTEM_USER;
        }
        else{
            $patient = $patient->first();
        }

        //We check if the test exists in our system if not we just save the request in stagingTable
        $testTypeId = TestType::getTestTypeIdByTestName($labRequest->investigation);

        if(is_null($testTypeId) && $labRequest->parentLabNo == '0')
        {
            $this->saveToExternalDump($labRequest, ExternalDump::TEST_NOT_FOUND);
            return;
        }
        //Check if visit exists, if true dont save again
        $visit = Visit::where('visit_number', '=', $labRequest->RevisitNumber)->get();
        if (!$visit->first())
        {
            $visit = new Visit();
            $visit->visit_type = 'Out-patient';
            // We'll save Visit in a transaction a little bit below
        }
        else{
            $visit = $visit->first();
        }

        $test = null;
        
        //Check via the labno, if this is a duplicate request and we already saved the test 
        $test = Test::where('external_id', '=', $labRequest->RequestID)->get();
        if (!$test->first())
        {
            //Specimen
            $specimen = new Specimen();
            $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')[0];

            // We'll save the Specimen in a transaction a little bit below
            $test = new Test();
            $test->test_type_id = $testTypeId;
            $test->test_status_id = Test::NOT_RECEIVED;
            $test->created_by = User::EXTERNAL_SYSTEM_USER; //Created by external system 0
            $test->requested_by = $labRequest->DoctorRequesting;
            $test->external_id = $labRequest->RequestID;

            DB::transaction(function() use ($visit, $specimen, $test, $patient) {
                $patient->save();
                $visit->patient_id = $patient->id;
                $visit->visit_number = Visit::orderBy('id', 'desc')->first()->id + 1;//$labRequest->RevisitNumber;
                $visit->save();
                $specimen->save();
                $test->visit_id = $visit->id;
                $test->specimen_id = $specimen->id;
                $test->save();
            });

            $this->saveToExternalDump($labRequest, $test->id);
            return;
        }
        
        $this->saveToExternalDump($labRequest, null);
        mssql_close($connection);
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
        $dumper = ExternalDump::firstOrNew(array('lab_no' => $labRequest->RequestID));
        $dumper->lab_no = $labRequest->RequestID;
        $dumper->parent_lab_no = 0; //Always zero
        if($dumper->test_id == null){
            $dumper->test_id = $testId;
        }
        $dumper->requesting_clinician = $labRequest->DoctorRequesting;
        $dumper->investigation = $labRequest->Name;
        $dumper->provisional_diagnosis = $labRequest->ProvisionalDiagnosis;
        $dumper->request_date = $labRequest->DateOfRequest;
        $dumper->order_stage = 'Out-patient';
        $dumper->patient_visit_number = $labRequest->RevisitNumber;
        $dumper->patient_id = $labRequest->PatientNumber;
        $dumper->full_name = $labRequest->FullNames;
        $dumper->dob = $this->getDobFromAge($labRequest->Age, $labRequest->DateOfRequest);;
        $dumper->gender = $labRequest->Sex;
        $dumper->address = $labRequest->PoBox;
        $dumper->phone_number = $labRequest->PatientsContact;
        $dumper->cost = $labRequest->Cost;
        $dumper->receipt_number = $labRequest->ReceiptNumber;
        $dumper->system_id = "medboss";
        $dumper->save();
    }

    public function send($testId)
    {
        //Sends results or any other flag back to where they came from
        $connection = $this->connectToMedboss();

        $test = Test::find($testId);
        $externalId = $test->external_id;
        $externalDump = ExternalDump::where('lab_no', '=', $externalId);
        if (!$externalDump->first()){
            //Can't be sent to the external system
            return false;
        }
        $userId = Auth::user()->id;
        $resultsEntered = date_create($test->time_entered);
        $dateResultEntered = date_format($resultsEntered, 'Y-m-d');
        $timeResultEntered = date_format($resultsEntered, 'h:i:s');

        $results = getFormattedResults($testId);

        $lab_request_no = intval($lab_request_no);

        if ($externalDump->first()->result_returned == 1) {
            $query = mssql_query("UPDATE BlissLabResults SET TestResults = '$result_ent' WHERE RequestID = '$externalId' ");
        }else{
            $query = mssql_query("INSERT INTO BlissLabResults (RequestID,OfferedBy,DateOffered, TimeOffered, TestResults)
                    VALUES ('$externalId','$userId','$dateResultEntered','$timeResultEntered','$result_ent') ");
        }
        
        if ($query) {
            //Set status in external lab-request to `sent`
            $updatedExternalRequest = ExternalDump::where('lab_no', '=', $externalId)->first();
            $updatedExternalRequest->result_returned = 1;
            $updatedExternalRequest->save();
        }else {
            //Set status in external lab-request to `sent`
            $updatedExternalRequest = ExternalDump::where('lab_no', '=', $externalId)->first();
            $updatedExternalRequest->result_returned = 2;
            $updatedExternalRequest->save();
            Log::error("MSSQL Query Error => ".mssql_get_last_message());
        }
        mssql_close($link);
    }

    public function connectToMedboss()
    {
        #MedBoss MSSQL Server Parameters
        //$server = '192.168.184.121:1432';
        $server = '192.168.6.4';
        $username = 'kapsabetadmin';
        $password = 'kapsabet';
        $database = '[Kapsabet]';
        $this->labRequestView  = 'LabRequestQueryForBliss';

        $link = mssql_connect($server, $username, $password);
        
        if (!$link)
        {
            Log::error("MSSQL connection Error: => ".mssql_get_last_message());
        }
        
        if (!mssql_select_db($database, $link)){
            Log::error("MSSQL Database Selection Error: => ".mssql_get_last_message());
        }
        return $link;
    }

    /**
    * Given the age in days we can derive the DOB, by subtracting now and the age
    * 
    * @param int age in days
    * @param date requestDate
    * @return date dob
    */
    public function getDobFromAge($age, $requestDate)
    {
        $requestDate = new DateTime($requestDate);
        $dateInterval = DateInterval::createFromDateString($age.' days');

        $dob = $requestDate->sub($dateInterval)->format('Y-m-d');
        return $dob;
    }

    /**
    * Results are formatted like Measure:result Measure:result 
    * for each of the measure of the test
    */
    public function getFormattedResults($testId)
    {
        $testResults = Test::find($testId)->TestResults;
        $formattedResults = '';

        foreach ($testResults as $testResult) {
            $measureName = $testResult->measure->name;
            $formattedResults .= $measureName.' : '.$testResult->result;
        }
        return $formattedResults;
    }
}
