<?php
/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

class SanitasInterfacerTest extends TestCase
{
    public function setup()
    {
        parent::setup();
        echo "\n\nSANITAS INTERFACER TEST\n\n";
        $this->app->bind('Interfacer', 'SanitasInterfacer');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->setVariables();
    }

    public function testRetrieveSingleRequest()
    {
        $this->call('POST', 'api/receiver', $this->labRequestJsonSimpleTest, 
                array(), array(), array('application/json'));

        $patient6 = Patient::find(6);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']['id'], $patient6->patient_number);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']['fullName'], $patient6->name);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']['dateOfBirth'], $patient6->dob);
        $this->assertEquals('M', $patient6->getGender()); //Male is converted M by the interfacer

        $visit8 = Visit::find(8);
        $this->assertEquals($this->labRequestJsonSimpleTest['patientVisitNumber'], $visit8->visit_number);
        $this->assertEquals(6, $visit8->patient_id); //PatientID 6 is the inserted patient for this request
        $this->assertEquals('Out-patient', $visit8->visit_type); 

        $specimen8 = Specimen::find(8);
        $this->assertEquals(23, $specimen8->specimen_type_id); //specimen_type_id is whole blood
        $this->assertEquals(0, $specimen8->created_by); //specimen_type_id is whole blood

        $test11 = Test::find(11);
        $this->assertEquals(0, $test11->created_by); //External system user
        $this->assertEquals(8, $test11->visit_id); //Visit id 8 for $visit8 up
        $this->assertEquals(1, $test11->test_type_id); //Ttype ID for BS for mps in seed
        $this->assertEquals(8,$test11->specimen_id); 
        $this->assertEquals(Test::NOT_RECEIVED, $test11->test_status_id);
        $this->assertEquals($this->labRequestJsonSimpleTest['requestingClinician'], $test11->requested_by);
        $this->assertEquals($this->labRequestJsonSimpleTest['labNo'], $test11->external_id);

        $exteral_dump1 = ExternalDump::find(1); //First record
        $this->assertEquals($this->labRequestJsonSimpleTest['labNo'], $exteral_dump1->labNo);
        $this->assertEquals($this->labRequestJsonSimpleTest['parentLabNo'], $exteral_dump1->parentLabNo);
        $this->assertEquals(11, $exteral_dump1->test_id);
        $this->assertEquals($this->labRequestJsonSimpleTest['requestingClinician'], $exteral_dump1->requestingClinician);
        $this->assertEquals($this->labRequestJsonSimpleTest['investigation'], $exteral_dump1->investigation);
        $this->assertEquals('', $exteral_dump1->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonSimpleTest['requestDate'], $exteral_dump1->requestDate);
        $this->assertEquals($this->labRequestJsonSimpleTest['orderStage'], $exteral_dump1->orderStage);
        $this->assertEquals($this->labRequestJsonSimpleTest['patientVisitNumber'], $exteral_dump1->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']['id'], $exteral_dump1->patient_id);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']["fullName"], $exteral_dump1->fullName);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']["dateOfBirth"], $exteral_dump1->dateOfBirth);
        $this->assertEquals($this->labRequestJsonSimpleTest['patient']['gender'], $exteral_dump1->gender);
        $this->assertEquals($this->labRequestJsonSimpleTest['address']["address"], $exteral_dump1->address);
        $this->assertEquals('', $exteral_dump1->postalCode);
        $this->assertEquals($this->labRequestJsonSimpleTest['address']["phoneNumber"], $exteral_dump1->phoneNumber);
        $this->assertEquals($this->labRequestJsonSimpleTest['address']["city"], $exteral_dump1->city);
        $this->assertEquals($this->labRequestJsonSimpleTest['cost'], $exteral_dump1->cost);
        $this->assertEquals($this->labRequestJsonSimpleTest['receiptNumber'], $exteral_dump1->receiptNumber);
        $this->assertEquals($this->labRequestJsonSimpleTest['receiptType'], $exteral_dump1->receiptType);
        $this->assertEquals('', $exteral_dump1->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump1->system_id);
    }

    public function testRetrieveMultipleRequests()
    {
        //Sending requests for urinalysis
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest1,
                array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest2,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest3,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest4,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest5,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest6,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest7,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest8,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest9,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest10,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest11,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest12,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest13,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest14,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest15,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest16,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest17,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest18,
                        array(), array(), array('application/json'));
        $this->call('POST', 'api/receiver', $this->labRequestJsonNestedTest19,
                        array(), array(), array('application/json'));

        $patient6 = Patient::find(6);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['id'], $patient6->patient_number);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['fullName'], $patient6->name);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['dateOfBirth'], $patient6->dob);
        $this->assertEquals('M', $patient6->getGender()); //Male is converted M by the interfacer

        $visit8 = Visit::find(8);
        $this->assertEquals($this->labRequestJsonNestedTest1['patientVisitNumber'], $visit8->visit_number);
        $this->assertEquals(6, $visit8->patient_id); //PatientID 6 is the inserted patient for this request
        $this->assertEquals('Out-patient', $visit8->visit_type); 

        $specimen8 = Specimen::find(8);
        $this->assertEquals(23, $specimen8->specimen_type_id); //specimen_type_id is whole blood
        $this->assertEquals(0, $specimen8->created_by); //specimen_type_id is whole blood

        $test11 = Test::find(11);
        $this->assertEquals(0, $test11->created_by); //External system user
        $this->assertEquals(8, $test11->visit_id); //Visit id 8 for $visit8 up
        $this->assertEquals(1, $test11->test_type_id); //Ttype ID for BS for mps in seed
        $this->assertEquals(8,$test11->specimen_id); 
        $this->assertEquals(Test::NOT_RECEIVED, $test11->test_status_id);
        $this->assertEquals($this->labRequestJsonNestedTest1['requestingClinician'], $test11->requested_by);
        $this->assertEquals($this->labRequestJsonNestedTest1['labNo'], $test11->external_id);
    }

    public function setVariables()
    {
        $this->labRequestJsonSimpleTest = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 596726,
                "parentLabNo": 0,
                "requestingClinician": "Leah  Wafula",
                "investigation": "BS for mps",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 647016,
                "patient": {
                    "id": 168967,
                    "fullName": "NYONGESA WATITWA WALELA",
                    "dateOfBirth": "1972-04-04 00:00:00",
                    "gender": "Male"
                },
                "address": {
                    "address": null,
                    "postalCode": null,
                    "phoneNumber": "",
                    "city": null
                }
            }', true);//When TRUE, returned objects will be converted into associative arrays.

        $this->labRequestJsonNestedTest1 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596699,"parentLabNo":0,"requestingClinician":"alfred  kuyi","investigation":"Urinalysis","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest2 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596700,"parentLabNo":596699,"requestingClinician":"alfred  kuyi","investigation":"Urine microscopy","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest3 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596701,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Pus cells","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest4 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596702,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"S. haematobium","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest5 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596703,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"T. vaginalis","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest6 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596704,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Yeast cells","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest7 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596705,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Red blood cells","requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest8 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596706,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Bacteria","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest9 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596707,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Spermatozoa","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest10 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596708,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"Epithelial cells","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest11 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596709,"parentLabNo":596700,"requestingClinician":"alfred  kuyi","investigation":"ph","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest12 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596710,"parentLabNo":596699,"requestingClinician":"alfred  kuyi","investigation":"Urine chemistry","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest13 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596711,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Glucose","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest14 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596712,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Ketones","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest15 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596713,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Proteins","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest16 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596714,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Blood","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest17 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596715,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Bilirubin","requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest18 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596716,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"Urobilinogen Phenlpyruvic acid","requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest19 =
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596717,"parentLabNo":596710,"requestingClinician":"alfred  kuyi","investigation":"pH","requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,"patient":{"id":326983,"fullName":"rose  nanjala","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
    }
}