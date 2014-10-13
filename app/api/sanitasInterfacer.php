<?php

class sanitasInterfacer implements interfacerInterface{

    public function get($labrequest)
    {
        //validate input
        //Check if json
        $this->process($labRequest)
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
        //Test if on dupluicate key works with save natively

        //Check if patient exists, if true dont save again
        $patient = Patient::where('patient_number', '==', $labRequest['patient']['id'])->get();
        if (!$patient)
        {
            $patient = new Patient();
            $patient->patient_number = $labRequest['patient']['id'];
            $patient->name = $labRequest['patient']['fullName'];
            $patient->gender = $labRequest['patient']['gender'];
            $patient->dob = $labRequest['patient']['dateOfBirth'] ;
            $patient->address = $labRequest['patient']['city'] ;
            $patient->phone_number = $labRequest['patient']['phoneNumber'] ;
            $patient->save();
        }

        //Check if visit exists, if true dont save again
        $visit = Visit::where('visit_number', '==', $labRequest['patientVisitNumber'])->get();
        if (!$visit)
        {
            $visit = new Visit();
            $visit->patient_id = Input::getpatient_id;
            if ($labRequest['orderStage'] == 'op'
            {
                $visit->visit_type = 'In-patient';//Should be a constant
            }
            else if ($labRequest['orderStage'] == 'ip'
            {
                $visit->visit_type = 'Out-patient';
            }
            $visit->visit_number = $labRequest['patientVisitNumber'];
            $visit->save();
        }

        //Check if parentLabNO is 0 thus its a test and not a measure
        if($labRequest['parentLabNo'] == '0')
        {
            //Check if we have not saved the test before, via labno
            $test = Test::where('external_id' '==' '$labRequest['labNo']');
            if (!$test) 
            {
                $test = new Test();
                $test->visit_id = $visit->id;
                $testTypeId = $test->getTestTypeIdByTestName($labRequest['investigation']);
                $test->test_type_id = $testTypeId;
                $test->specimen_id = $specimen->id;
                $test->test_status_id = $test::NOT_RECEIVED
                $test->created_by = $test::EXTERNAL_SYSTEM_USER; //Created by external system 0
                $test->requested_by = $labRequest['requestingClinician'];
                $test->external_id = $labRequest['labNo'];
                $test->save();

                //Specimen
                $specimen = new Specimen();
                $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')->first();
                $specimen->created_by = $specimen::EXTERNAL_SYSTEM_USER;
                $specimen->referred_to = 0; //No one
                $specimen->referred_from = 0;
                $specimen->save();
            }
        }

        //Dumping all the received requests to stagingTable
        $dumper = new Staging();
        $dumper->labno = $labRequest['labNo'];
        $dumper->parentlabno = $labRequest['parentLabNo'];
        $dumper->test_id = $test->id;
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