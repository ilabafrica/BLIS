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
    * Sends results back to the originating system
    */
    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }

    /**
     * Function for processing the requests we receive from the external system
     * and putting the data into our system.
     *
     * @var array lab _requests
     */
    public function process($labRequest)
    {
        //Check if it is a payment request. Similar request but receiptnumber not null
        //Test if on duplicate key works with save natively

        //We check if the test exists in our system if not we just save the request in stagingTable
        $testType = new TestType();
        $testTypeId = $testType->getTestTypeIdByTestName("BS for mps");

        if(is_null($testTypeId))
        {
            $this->saveToExternalDump($labRequest, ExternalDump::TEST_NOT_FOUND);
            return false;
        }

        //Check if patient exists, if true dont save again
        $patient = Patient::where('patient_number', '==', $labRequest['patient']['id'])->get();
        if ($patient->isEmpty())
        {
            $patient = new Patient();
            $patient->patient_number = $labRequest['patient']['id'];
            $patient->name = $labRequest['patient']['fullName'];
            $patient->gender = $labRequest['patient']['gender'];
            $patient->dob = $labRequest['patient']['dateOfBirth'] ;
            $patient->address = $labRequest['address']['address'] ;
            $patient->phone_number = $labRequest['address']['phoneNumber'] ;
            $patient->save();
        }

        //Check if visit exists, if true dont save again
        $visit = Visit::where('visit_number', '==', $labRequest['patientVisitNumber'])->get();
        if ($visit->isEmpty())
        {
            $visit = new Visit();
            $visit->patient_id = $patient->id;
            if ($labRequest['orderStage'] == 'op')
            {
                $visit->visit_type = 'In-patient';//Should be a constant
            }
            else if ($labRequest['orderStage'] == 'ip')
            {
                $visit->visit_type = 'Out-patient';
            }
            $visit->visit_number = $labRequest['patientVisitNumber'];
            $visit->save();
        }

        $test = null;
        //Check if parentLabNO is 0 thus its the main test and not a measure
        if($labRequest['parentLabNo'] == '0')
        {
            //Check via the labno, if this is a duplicate request and we already saved the test 
            $test = Test::where('external_id', '==', $labRequest['labNo'])->get();
            if ($test->isEmpty()) 
            {
                //Specimen
                $specimen = new Specimen();
                $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')[0];
                $specimen->referred_to = 0; //No one
                $specimen->referred_from = 0;
                $specimen->save();

                $test = new Test();
                $test->visit_id = $visit->id;
                $test->test_type_id = $testTypeId;
                $test->specimen_id = $specimen->id;
                $test->test_status_id = $test::NOT_RECEIVED;
                $test->created_by = User::EXTERNAL_SYSTEM_USER; //Created by external system 0
                $test->requested_by = $labRequest['requestingClinician'];
                $test->external_id = $labRequest['labNo'];
                $test->save();

                $this->saveToExternalDump($labRequest, $test->id);
                return true;
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
        $dumper = new ExternalDump();
        $dumper->labno = $labRequest['labNo'];
        $dumper->parentlabno = $labRequest['parentLabNo'];
        $dumper->test_id = $testId;
        $dumper->requestingclinician = $labRequest['requestingClinician'];
        $dumper->investigation = $labRequest['investigation'];
        $dumper->provisional_diagnosis = '';
        $dumper->requestdate = $labRequest['requestDate'];
        $dumper->orderstage = $labRequest['orderStage'];
        $dumper->patientvisitnumber = $labRequest['patientVisitNumber'];
        $dumper->patient_id = $labRequest['patient']['id'];
        $dumper->fullname = $labRequest['patient']["fullName"];
        $dumper->dateofbirth = $labRequest['patient']["dateOfBirth"];
        $dumper->gender = $labRequest['patient']['gender'];
        $dumper->address = $labRequest['address']["address"];
        $dumper->postalcode = '';
        $dumper->phonenumber = $labRequest['address']["phoneNumber"];
        $dumper->city = $labRequest['address']["city"];
        $dumper->cost = $labRequest['cost'];
        $dumper->receiptnumber = $labRequest['receiptNumber'];
        $dumper->receipttype = $labRequest['receiptType'];
        $dumper->waiver_no = '';
        $dumper->system_id = "sanitas";
        $dumper->save();
    }
}