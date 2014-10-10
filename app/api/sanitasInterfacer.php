<?php

class sanitasInterfacer implements interfacerInterface{

    public function get($labrequest)
    {
        // validate input
        //Check if json
        $this->process($labRequest)
    }

    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }

    public function process($labRequest)
    {
        //split data to specimen, test and patient
        //Check if patient exists
        // if (isPatient($labRequest)) 
       
        //Check if it is a payment request. Similar request but receiptnumber not null

        //Check if a test or measure and group tests

        //Patient
        $patient = new Patient(); //Or get the existing one if we already have his records
        $patient->patient_number = $labRequest['patient']['id'];
        $patient->name = $labRequest['patient']['fullName'];
        $patient->gender = $labRequest['patient']['gender'];
        $patient->dob = $labRequest['patient']['dateOfBirth'] ;
        $patient->address = $labRequest['patient']['city'] ;
        $patient->phone_number = $labRequest['patient']['phoneNumber'] ;

        //visit
        $visit = new Visit;
        $visit->patient_id = Input::get('patient_id');
        if ($labRequest['orderStage'] == 'op') 
        {
            $visit->visit_type = 'In-patient'; //Should be a constant
        }
        else if ($labRequest['orderStage'] == 'ip') 
        {
            $visit->visit_type = 'Out-patient';
        }
        $visit->visit_number = $labRequest['patientVisitNumber'];
        $visit->save();

        $test = new Test();
        $test->visit_id = $visit->id;
        $testTypeId = $test->getTestTypeIdByTestName($labRequest['investigation']);
        $test->test_type_id = $testTypeId;
        $test->specimen_id = $specimen->id;
        $test->test_status_id = $test::NOT_RECEIVED
        $test->created_by = $test::EXTERNAL_SYSTEM_USER; //Created by external system 0
        $test->requested_by = $labRequest['requestingClinician'];

        //Specimen
        $specimen = new Specimen;
        $specimen->specimen_type_id = TestType::find($testTypeId)->specimenTypes->lists('id')->first();
        $specimen->created_by = $specimen::EXTERNAL_SYSTEM_USER;
        $specimen->referred_to = 0; //No one
        $specimen->referred_from = 0;

        //Save these to our system

        // requestDate
        // cost receiptNumber receiptType


                    #labNo
                    '"'.$request_data['labNo'].'",'.
                    #parentLabNo
                    '"'.$request_data['parentLabNo'].'",'.
                    #requestingClinician
                    '"'.$request_data['requestingClinician'].'",'.
                    #investigation
                    '"'.$request_data['investigation'].'",'.
                    #requestDate
                    '"'.$request_data['requestDate'].'",'.
                    #orderStage
                    '"'.$request_data['orderStage'].'",'.
                    #patientVisitNumber
                    '"'.$request_data['patientVisitNumber'].'",'.
                    #patient_id
                    '"'.$request_data['patient']['id'].'",'.
                    #full_name
                    '"'.$request_data['patient']["fullName"].'",'.
                    #dateOfBirth
                    '"'.$request_data['patient']["dateOfBirth"].'",'.
                    #age
                    '"'."NULL".'",'.
                    #gender
                    '"'.$request_data['patient']['gender'].'",'.
                    #address
                    '"'.$request_data['address']["address"].'",'.
                    #postalCode
                    '"'.$request_data['address']["postalCode"].'",'.
                    #phoneNumber
                    '"'.$request_data['address']["phoneNumber"].'",'.
                    #city
                    '"'.$request_data['address']["city"].'",'.
                    #revisitNumber
                    '"'."NULL".'",'.
                    #cost
                    '"'.$request_data['cost'].'",'.
                    #patientContact
                    '"'."NULL".'",'.
                    #receiptNumber
                    '"'.$request_data['receiptNumber'].'",'.
                    #receiptType
                    '"'.$request_data['receiptType'].'",'.
                    #waiverNo
                    '"'."NULL".'",'.
                    #comments
                    '"'."NULL".'",'.
                    #provisionalDiagnosis
                    '"'."NULL".'",'.
                    #system_id
                    '"'."sanitas".'"';
                    
                    $value_string.= ')';
                    
                    $LabRequest = $value_string;
                    
                    //Save all requests 
                    API::save_external_lab_request($LabRequest);
                 }       
                }
        }
    }
}