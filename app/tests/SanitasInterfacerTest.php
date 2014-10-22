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
        $this->app->bind('Interfacer', 'SanitasInterfacer');
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->setVariables();
    }

    public function testRetrieveSingleRequest()
    {
        echo "\n\nSANITAS INTERFACER TEST\n\n";
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

    public function testRequestForTestNotFound()
    {
        $this->call('POST', 'api/receiver', $this->labRequestJsonSimpleTestNotFoundInSanitas, 
                array(), array(), array('application/json'));

        $patient6 = Patient::find(6);
        $this->assertNull($patient6);

        $visit8 = Visit::find(8);
        $this->assertNull($visit8);

        $specimen8 = Specimen::find(8);
        $this->assertNull($specimen8);

        $test11 = Test::find(11);
        $this->assertNull($test11);

        $exteral_dump1 = ExternalDump::find(1); //First record
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['labNo'], $exteral_dump1->labNo);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['parentLabNo'], $exteral_dump1->parentLabNo);
        $this->assertEquals(0, $exteral_dump1->test_id);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['requestingClinician'], $exteral_dump1->requestingClinician);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['investigation'], $exteral_dump1->investigation);
        $this->assertEquals('', $exteral_dump1->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['requestDate'], $exteral_dump1->requestDate);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['orderStage'], $exteral_dump1->orderStage);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['patientVisitNumber'], $exteral_dump1->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['patient']['id'], $exteral_dump1->patient_id);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['patient']["fullName"], $exteral_dump1->fullName);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['patient']["dateOfBirth"], $exteral_dump1->dateOfBirth);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['patient']['gender'], $exteral_dump1->gender);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['address']["address"], $exteral_dump1->address);
        $this->assertEquals('', $exteral_dump1->postalCode);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['address']["phoneNumber"], $exteral_dump1->phoneNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['address']["city"], $exteral_dump1->city);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['cost'], $exteral_dump1->cost);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['receiptNumber'], $exteral_dump1->receiptNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestNotFoundInSanitas['receiptType'], $exteral_dump1->receiptType);
        $this->assertEquals('', $exteral_dump1->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump1->system_id);
    }

    public function testRetrieveMultipleRequests()
    {
        //Sending requests for urinalysis
        Interfacer::retrieve($this->labRequestJsonNestedTest1);
        Interfacer::retrieve($this->labRequestJsonNestedTest2);
        Interfacer::retrieve($this->labRequestJsonNestedTest3);
        Interfacer::retrieve($this->labRequestJsonNestedTest4);
        Interfacer::retrieve($this->labRequestJsonNestedTest5);
        Interfacer::retrieve($this->labRequestJsonNestedTest6);
        Interfacer::retrieve($this->labRequestJsonNestedTest7);
        Interfacer::retrieve($this->labRequestJsonNestedTest8);
        Interfacer::retrieve($this->labRequestJsonNestedTest9);
        Interfacer::retrieve($this->labRequestJsonNestedTest10);
        Interfacer::retrieve($this->labRequestJsonNestedTest11);
        Interfacer::retrieve($this->labRequestJsonNestedTest12);
        Interfacer::retrieve($this->labRequestJsonNestedTest13);
        Interfacer::retrieve($this->labRequestJsonNestedTest14);
        Interfacer::retrieve($this->labRequestJsonNestedTest15);
        Interfacer::retrieve($this->labRequestJsonNestedTest16);
        Interfacer::retrieve($this->labRequestJsonNestedTest17);
        Interfacer::retrieve($this->labRequestJsonNestedTest18);
        Interfacer::retrieve($this->labRequestJsonNestedTest19);

        $patient6 = Patient::find(6);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['id'], $patient6->patient_number);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['fullName'], $patient6->name);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['dateOfBirth'], $patient6->dob);
        $this->assertEquals('F', $patient6->getGender()); //Male is converted M by the interfacer

        $visit8 = Visit::find(8);
        $this->assertEquals($this->labRequestJsonNestedTest1['patientVisitNumber'], $visit8->visit_number);
        $this->assertEquals(6, $visit8->patient_id); //PatientID 6 is the inserted patient for this request
        $this->assertEquals('In-patient', $visit8->visit_type); 

        $specimen8 = Specimen::find(8);
        $this->assertEquals(20, $specimen8->specimen_type_id); //specimen_type_id is Urine
        $this->assertEquals(0, $specimen8->created_by);

        $test11 = Test::find(11);
        $this->assertEquals(0, $test11->created_by); //External system user
        $this->assertEquals(8, $test11->visit_id); //Visit id 8 for $visit8 up
        $this->assertEquals(4, $test11->test_type_id); //Ttype ID for Urinalysis in seed
        $this->assertEquals(8, $test11->specimen_id); 
        $this->assertEquals(Test::NOT_RECEIVED, $test11->test_status_id);
        $this->assertEquals($this->labRequestJsonNestedTest1['requestingClinician'], $test11->requested_by);
        $this->assertEquals($this->labRequestJsonNestedTest1['labNo'], $test11->external_id);

        $patient7 = Patient::find(7);
        $this->assertNull($patient7);

        $visit9 = Visit::find(9);
        $this->assertNull($visit9);

        $specimen9 = Specimen::find(9);
        $this->assertNull($specimen9);

        $test12 = Test::find(12);
        $this->assertNull($test12);

        $exteral_dump1 = ExternalDump::find(1); //First record
        $this->assertEquals($this->labRequestJsonNestedTest1['labNo'], $exteral_dump1->labNo);
        $this->assertEquals($this->labRequestJsonNestedTest1['parentLabNo'], $exteral_dump1->parentLabNo);
        $this->assertEquals(11, $exteral_dump1->test_id);
        $this->assertEquals($this->labRequestJsonNestedTest1['requestingClinician'], $exteral_dump1->requestingClinician);
        $this->assertEquals($this->labRequestJsonNestedTest1['investigation'], $exteral_dump1->investigation);
        $this->assertEquals('', $exteral_dump1->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonNestedTest1['requestDate'], $exteral_dump1->requestDate);
        $this->assertEquals($this->labRequestJsonNestedTest1['orderStage'], $exteral_dump1->orderStage);
        $this->assertEquals($this->labRequestJsonNestedTest1['patientVisitNumber'], $exteral_dump1->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['id'], $exteral_dump1->patient_id);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']["fullName"], $exteral_dump1->fullName);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']["dateOfBirth"], $exteral_dump1->dateOfBirth);
        $this->assertEquals($this->labRequestJsonNestedTest1['patient']['gender'], $exteral_dump1->gender);
        $this->assertEquals($this->labRequestJsonNestedTest1['address']["address"], $exteral_dump1->address);
        $this->assertEquals('', $exteral_dump1->postalCode);
        $this->assertEquals($this->labRequestJsonNestedTest1['address']["phoneNumber"], $exteral_dump1->phoneNumber);
        $this->assertEquals($this->labRequestJsonNestedTest1['address']["city"], $exteral_dump1->city);
        $this->assertEquals($this->labRequestJsonNestedTest1['cost'], $exteral_dump1->cost);
        $this->assertEquals($this->labRequestJsonNestedTest1['receiptNumber'], $exteral_dump1->receiptNumber);
        $this->assertEquals($this->labRequestJsonNestedTest1['receiptType'], $exteral_dump1->receiptType);
        $this->assertEquals('', $exteral_dump1->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump1->system_id);

        $exteral_dump10 = ExternalDump::find(10); //First record
        $this->assertEquals($this->labRequestJsonNestedTest10['labNo'], $exteral_dump10->labNo);
        $this->assertEquals($this->labRequestJsonNestedTest10['parentLabNo'], $exteral_dump10->parentLabNo);
        $this->assertEquals(null, $exteral_dump10->test_id);
        $this->assertEquals($this->labRequestJsonNestedTest10['requestingClinician'], $exteral_dump10->requestingClinician);
        $this->assertEquals($this->labRequestJsonNestedTest10['investigation'], $exteral_dump10->investigation);
        $this->assertEquals('', $exteral_dump10->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonNestedTest10['requestDate'], $exteral_dump10->requestDate);
        $this->assertEquals($this->labRequestJsonNestedTest10['orderStage'], $exteral_dump10->orderStage);
        $this->assertEquals($this->labRequestJsonNestedTest10['patientVisitNumber'], $exteral_dump10->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonNestedTest10['patient']['id'], $exteral_dump10->patient_id);
        $this->assertEquals($this->labRequestJsonNestedTest10['patient']["fullName"], $exteral_dump10->fullName);
        $this->assertEquals($this->labRequestJsonNestedTest10['patient']["dateOfBirth"], $exteral_dump10->dateOfBirth);
        $this->assertEquals($this->labRequestJsonNestedTest10['patient']['gender'], $exteral_dump10->gender);
        $this->assertEquals($this->labRequestJsonNestedTest10['address']["address"], $exteral_dump10->address);
        $this->assertEquals('', $exteral_dump10->postalCode);
        $this->assertEquals($this->labRequestJsonNestedTest10['address']["phoneNumber"], $exteral_dump10->phoneNumber);
        $this->assertEquals($this->labRequestJsonNestedTest10['address']["city"], $exteral_dump10->city);
        $this->assertEquals($this->labRequestJsonNestedTest10['cost'], $exteral_dump10->cost);
        $this->assertEquals($this->labRequestJsonNestedTest10['receiptNumber'], $exteral_dump10->receiptNumber);
        $this->assertEquals($this->labRequestJsonNestedTest10['receiptType'], $exteral_dump10->receiptType);
        $this->assertEquals('', $exteral_dump10->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump10->system_id);

        $exteral_dump19 = ExternalDump::find(19); //First record
        $this->assertEquals($this->labRequestJsonNestedTest19['labNo'], $exteral_dump19->labNo);
        $this->assertEquals($this->labRequestJsonNestedTest19['parentLabNo'], $exteral_dump19->parentLabNo);
        $this->assertEquals(null, $exteral_dump19->test_id);
        $this->assertEquals($this->labRequestJsonNestedTest19['requestingClinician'], $exteral_dump19->requestingClinician);
        $this->assertEquals($this->labRequestJsonNestedTest19['investigation'], $exteral_dump19->investigation);
        $this->assertEquals('', $exteral_dump19->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonNestedTest19['requestDate'], $exteral_dump19->requestDate);
        $this->assertEquals($this->labRequestJsonNestedTest19['orderStage'], $exteral_dump19->orderStage);
        $this->assertEquals($this->labRequestJsonNestedTest19['patientVisitNumber'], $exteral_dump19->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonNestedTest19['patient']['id'], $exteral_dump19->patient_id);
        $this->assertEquals($this->labRequestJsonNestedTest19['patient']["fullName"], $exteral_dump19->fullName);
        $this->assertEquals($this->labRequestJsonNestedTest19['patient']["dateOfBirth"], $exteral_dump19->dateOfBirth);
        $this->assertEquals($this->labRequestJsonNestedTest19['patient']['gender'], $exteral_dump19->gender);
        $this->assertEquals($this->labRequestJsonNestedTest19['address']["address"], $exteral_dump19->address);
        $this->assertEquals('', $exteral_dump19->postalCode);
        $this->assertEquals($this->labRequestJsonNestedTest19['address']["phoneNumber"], $exteral_dump19->phoneNumber);
        $this->assertEquals($this->labRequestJsonNestedTest19['address']["city"], $exteral_dump19->city);
        $this->assertEquals($this->labRequestJsonNestedTest19['cost'], $exteral_dump19->cost);
        $this->assertEquals($this->labRequestJsonNestedTest19['receiptNumber'], $exteral_dump19->receiptNumber);
        $this->assertEquals($this->labRequestJsonNestedTest19['receiptType'], $exteral_dump19->receiptType);
        $this->assertEquals('', $exteral_dump19->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump19->system_id);

        $exteral_dump20 = ExternalDump::find(20);
        $this->assertNull($exteral_dump20);
    }

    public function testPaymentRequest()
    {
        //Sending requests for urinalysis
        Interfacer::retrieve($this->labRequestJsonSimpleTest); //First request for the test itself

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

        Interfacer::retrieve($this->labRequestJsonSimpleTestPayMentRequest); //Second request similar to first but with payment details

        $patient6 = Patient::find(6);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']['id'], $patient6->patient_number);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']['fullName'], $patient6->name);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']['dateOfBirth'], $patient6->dob);
        $this->assertEquals('M', $patient6->getGender()); //Male is converted M by the interfacer

        $visit8 = Visit::find(8);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patientVisitNumber'], $visit8->visit_number);
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
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['requestingClinician'], $test11->requested_by);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['labNo'], $test11->external_id);

        $exteral_dump1 = ExternalDump::find(1); //First record
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['labNo'], $exteral_dump1->labNo);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['parentLabNo'], $exteral_dump1->parentLabNo);
        $this->assertEquals(null, $exteral_dump1->test_id);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['requestingClinician'], $exteral_dump1->requestingClinician);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['investigation'], $exteral_dump1->investigation);
        $this->assertEquals('', $exteral_dump1->provisional_diagnosis);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['requestDate'], $exteral_dump1->requestDate);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['orderStage'], $exteral_dump1->orderStage);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patientVisitNumber'], $exteral_dump1->patientVisitNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']['id'], $exteral_dump1->patient_id);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']["fullName"], $exteral_dump1->fullName);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']["dateOfBirth"], $exteral_dump1->dateOfBirth);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['patient']['gender'], $exteral_dump1->gender);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['address']["address"], $exteral_dump1->address);
        $this->assertEquals('', $exteral_dump1->postalCode);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['address']["phoneNumber"], $exteral_dump1->phoneNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['address']["city"], $exteral_dump1->city);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['cost'], $exteral_dump1->cost);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['receiptNumber'], $exteral_dump1->receiptNumber);
        $this->assertEquals($this->labRequestJsonSimpleTestPayMentRequest['receiptType'], $exteral_dump1->receiptType);
        $this->assertEquals('', $exteral_dump1->waiver_no);
        $this->assertEquals("sanitas", $exteral_dump1->system_id);

        $exteral_dump2 = ExternalDump::find(2);
        $this->assertNull($exteral_dump2); //Assert the second request updated the first and not a new request
    }

    public function setVariables()
    {
        $this->labRequestJsonSimpleTest = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 596726,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "BS for mps",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 464436,
                "patient": {
                    "id": 234534,
                    "fullName": "ADSASDF DASJF ADF",
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

        $this->labRequestJsonSimpleTestPayMentRequest = 
            json_decode('{"cost": 600,
                "receiptNumber": "RT-1413273385577",
                "receiptType": "standard",
                "labNo": 596726,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "BS for mps",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 464436,
                "patient": {
                    "id": 234534,
                    "fullName": "ADSASDF DASJF ADF",
                    "dateOfBirth": "1972-04-04 00:00:00",
                    "gender": "Male"
                },
                "address": {
                    "address": null,
                    "postalCode": null,
                    "phoneNumber": "",
                    "city": null
                }
            }', true);

        $this->labRequestJsonSimpleTestNotFoundInSanitas = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 596726,
                "parentLabNo": 0,
                "requestingClinician": "DRONGO  SKAKA",
                "investigation": "SOME UNKOWN TESTS",
                "requestDate": "2013-10-16 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 856443,
                "patient": {
                    "id": 63456,
                    "fullName": "SANDSTORM BY DARUDE",
                    "dateOfBirth": "1932-04-04 00:00:00",
                    "gender": "Male"
                },
                "address": {
                    "address": null,
                    "postalCode": null,
                    "phoneNumber": "",
                    "city": null
                }
            }', true);

        $this->labRequestJsonNestedTest1 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596699,"parentLabNo":0,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urinalysis",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest2 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596700,"parentLabNo":596699,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urine microscopy",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest3 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596701,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Pus cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest4 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596702,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"S. haematobium",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest5 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596703,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"T. vaginalis",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest6 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596704,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Yeast cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest7 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596705,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Red blood cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest8 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596706,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Bacteria",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest9 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596707,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Spermatozoa",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest10 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596708,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Epithelial cells",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest11 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596709,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"ph",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest12 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596710,"parentLabNo":596699,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urine chemistry",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest13 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596711,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Glucose",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest14 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596712,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Ketones",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest15 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596713,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Proteins",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest16 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596714,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Blood",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest17 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596715,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Bilirubin",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest18 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596716,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urobilinogen Phenlpyruvic acid",
                "requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestJsonNestedTest19 = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596717,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"pH",
                "requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
    }
}