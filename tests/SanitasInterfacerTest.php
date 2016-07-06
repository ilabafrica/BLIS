<?php
/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Test;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\User;
use App\Models\ExternalDump;

class SanitasInterfacerTest extends TestCase
{
    
    public function setup()
    {
        parent::setup();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->setVariables();
    }

    // todo: check how l5 phpunit test works with sanitas and medboss json strings also how to handle in the controller and model
    public function testRetrieveSingleRequest()
    {
        // $this->app->bind('App\Api\InterfacerInterface', 'App\Api\SanitasInterfacer');
        echo "\n\nSANITAS INTERFACER TEST\n\n";
		$this->withoutMiddleware();
        // Invoke API URL making a single test request (presumed successful)
// dd($this->labRequestJsonSimpleTest);


        $this->json('POST', 'api/receiver', [$this->labRequestJsonSimpleTest]);

        $labR = json_decode($this->labRequestJsonSimpleTest);

        // Was the data stored in the external dump?
        $externalDump = ExternalDump::where('lab_no', '=', $labR->labNo)->get();
        $this->assertTrue(count($externalDump) > 0);

        // Was a new patient created?
        $patient = Patient::where('external_patient_number', '=', $externalDump->first()->patient_id)->get();
        $this->assertTrue(count($patient) > 0);

        // Is there a Visit for this new patient?
        $visit = Visit::where('patient_id', '=', $patient->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Test for this visit?
        $test = Test::where('visit_id', '=', $visit->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Specimen for this new Test?
        $specimen = $test->first()->specimen;
        $this->assertTrue(count($specimen) > 0);

    }
/*
    public function testRequestForTestNotFound()
    {
		$this->withoutMiddleware();
        // Invoke API URL to insert seed data
        $this->call('POST', 'api/receiver', [], [], [],
            [], $this->labRequestJsonSimpleTestNotFoundInSanitas);

        $labRNF = json_decode($this->labRequestJsonSimpleTestNotFoundInSanitas);

        // Was the data stored in the external dump?
        $externalDump = ExternalDump::where('lab_no', '=', $labRNF->labNo)->get();
        $this->assertTrue(count($externalDump) > 0);

        // Was a new patient created?
        $patient = Patient::where('external_patient_number', '=', $externalDump->first()->patient_id)->get();
        $this->assertTrue(count($patient) > 0);

        // Is there a Visit for this new patient?
        $visit = Visit::where('patient_id', '=', $patient->first()->id)->get();
        $this->assertTrue(empty($visit->first()));

        // Is there a Test for this visit? ... a Specimen for this new Test? No need to check these.
    }

    public function testRetrieveMultipleRequests()
    {
        //Sending requests for urinalysis
        for ($i=0; $i < count($this->labRequestUrinalysis); $i++) { 
            InterfacerInterface::retrieve($this->labRequestUrinalysis[$i]);
        }

        $labR = json_decode($this->labRequestJsonSimpleTest);
        InterfacerInterface::retrieve($labR); //bs for mps

        // Check that all the 'urinalysis' data was stored
        // Was the data stored in the external dump?
        for ($i=0; $i < count($this->labRequestUrinalysis); $i++) { 
            $externalDump[] = ExternalDump::where('lab_no', '=', $this->labRequestUrinalysis[$i]->labNo)->get();
            $this->assertTrue(count($externalDump{$i}) > 0);
        }

        // Was a new patient created?
        $patient = Patient::where('external_patient_number', '=', $externalDump[0]->first()->patient_id)->get();
        $this->assertTrue(count($patient) > 0);

        // Is there a Visit for this new patient?
        $visit = Visit::where('patient_id', '=', $patient->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Test for this visit?
        $test = Test::where('visit_id', '=', $visit->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Specimen for this new Test?
        $specimen = $test->first()->specimen;
        $this->assertTrue(count($specimen) > 0);

        // Check that the 'bs for mps' data was stored
        // Was the data stored in the external dump?
        $externalDumpBS = ExternalDump::where('lab_no', '=', $labR->labNo)->get();
        $this->assertTrue(count($externalDump) > 0);

        // Was a new patient created?
        $patient = Patient::where('external_patient_number', '=', $externalDumpBS->first()->patient_id)->get();
        $this->assertTrue(count($patient) > 0);

        // Is there a Visit for this new patient?
        $visit = Visit::where('patient_id', '=', $patient->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Test for this visit?
        $test = Test::where('visit_id', '=', $visit->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Specimen for this new Test?
        $specimen = $test->first()->specimen;
        $this->assertTrue(count($specimen) > 0);
    }

    public function testPaymentRequest()
    {
		$this->withoutMiddleware();
        // Invoke API URL making a single test request (presumed successful)
        $this->call('POST', 'api/receiver', [], [], [], [], $this->labRequestJsonSimpleTest);

        $labR = json_decode($this->labRequestJsonSimpleTest);

        // Was the data stored in the external dump?
        $externalDump = ExternalDump::where('lab_no', '=', $labR->labNo)->get();
        $this->assertTrue(count($externalDump) > 0);

        // Was a new patient created?
        $patient = Patient::where('external_patient_number', '=', $externalDump->first()->patient_id)->get();
        $this->assertTrue(count($patient) > 0);

        // Is there a Visit for this new patient?
        $visit = Visit::where('patient_id', '=', $patient->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Test for this visit?
        $test = Test::where('visit_id', '=', $visit->first()->id)->get();
        $this->assertTrue(count($visit) > 0);

        // Is there a Specimen for this new Test?
        $specimen = $test->first()->specimen;
        $this->assertTrue(count($specimen) > 0);

        $labRPR = json_decode($this->labRequestJsonSimpleTestPayMentRequest);

         //Second request similar to first but with payment details
        InterfacerInterface::retrieve($labRPR);

        // Was the data stored in the external dump?
        // There should only be one record. The second only updates the first
        $externalDumpPayment = ExternalDump::where('lab_no', '=', $labR->labNo)->get();
        $this->assertTrue(count($externalDumpPayment) == 1);
        $this->assertEquals($labRPR->receiptNumber, $externalDumpPayment->first()->receipt_number);
    }

    public function rethinktestInterfacerSend()
    {
        //Curent method of testing not working
        InterfacerInterface::send('13');

        $dump1 = ExternalDump::find(1);

        $this->assertEquals($dump1->result_returned, 1);

        $extD = new ExternalDump();
        $externalLabRequestTree = $extD->getLabRequestAndMeasures($dump1->lab_no);

        foreach ($externalLabRequestTree as $key => $externalLabRequest) {
            $this->assertEquals(1, $externalLabRequest->result_returned);
        }
    }

    public function testMultipleVisitTypes()
    {
        InterfacerInterface::retrieve($this->labRequestJsonSimpleTestTwoVisits[0]);
        InterfacerInterface::retrieve($this->labRequestJsonSimpleTestTwoVisits[1]);
        InterfacerInterface::retrieve($this->labRequestJsonSimpleTestTwoVisits[2]);
        InterfacerInterface::retrieve($this->labRequestJsonSimpleTestTwoVisits[3]);
        InterfacerInterface::retrieve($this->labRequestJsonSimpleTestTwoVisits[4]);

        $externalDump = ExternalDump::where('lab_no', '=', $this->labRequestJsonSimpleTestTwoVisits[0]->labNo)->get();
        $this->assertTrue(count($externalDump) == 1);
        $this->assertEquals($this->labRequestJsonSimpleTestTwoVisits[0]->patientVisitNumber, $externalDump->first()->patient_visit_number);

        $externalDump = ExternalDump::where('lab_no', '=', $this->labRequestJsonSimpleTestTwoVisits[1]->labNo)->get();
        $this->assertTrue(count($externalDump) == 1);
        $this->assertEquals($this->labRequestJsonSimpleTestTwoVisits[1]->patientVisitNumber, $externalDump->first()->patient_visit_number);

        $externalDump = ExternalDump::where('lab_no', '=', $this->labRequestJsonSimpleTestTwoVisits[2]->labNo)->get();
        $this->assertTrue(count($externalDump) == 1);
        $this->assertEquals($this->labRequestJsonSimpleTestTwoVisits[2]->patientVisitNumber, $externalDump->first()->patient_visit_number);

        $externalDump = ExternalDump::where('lab_no', '=', $this->labRequestJsonSimpleTestTwoVisits[3]->labNo)->get();
        $this->assertTrue(count($externalDump) == 1);
        $this->assertEquals($this->labRequestJsonSimpleTestTwoVisits[3]->patientVisitNumber, $externalDump->first()->patient_visit_number);

        $externalDump = ExternalDump::where('lab_no', '=', $this->labRequestJsonSimpleTestTwoVisits[4]->labNo)->get();
        $this->assertTrue(count($externalDump) == 1);
        $this->assertEquals($this->labRequestJsonSimpleTestTwoVisits[4]->patientVisitNumber, $externalDump->first()->patient_visit_number);

        // Is there a Visit for this new patient?
        $visit = Visit::where('visit_number', '=', $this->labRequestJsonSimpleTestTwoVisits[0]->patientVisitNumber)->get();
        //var_dump($visit);
        //Two records inserted for same external visit
        $this->assertEquals(2, count($visit));
        //First is IP
        $this->assertEquals('Out-patient', $visit->first()->visit_type);
        //Second is OP
        $this->assertEquals('In-patient', $visit[1]->visit_type );
        //Two distinct internal visit id's
        $this->assertTrue($visit->first()->id != $visit[1]->id);
        //Check visit number is the same
        $this->assertEquals($visit->first()->visit_number, $visit[1]->visit_number);
    }*/

    public function setVariables()
    {
        $this->labRequestJsonSimpleTest = 
            '{"cost": null,
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
            }';

        $this->labRequestJsonSimpleTestPayMentRequest = 
            '{"cost": 600,
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
            }';

        $this->labRequestJsonSimpleTestNotFoundInSanitas = 
            '{"cost": null,
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
            }';

        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597579,"parentLabNo":0,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Urinalysis","requestDate":"2014-10-15 08:35:38","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597580,"parentLabNo":597579,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Urine microscopy","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597581,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Pus cells","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597582,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"S. haematobium","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597583,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"T. vaginalis","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597584,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Yeast cells","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597585,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Red blood cells","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597586,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Bacteria","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597587,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Spermatozoa","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597588,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Epithelial cells","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597589,"parentLabNo":597580,"requestingClinician":"DOCTOR DING RING",
                "investigation":"ph","requestDate":"2014-10-15 08:35:39","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597590,"parentLabNo":597579,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Urine chemistry","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597591,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Glucose","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597592,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Ketones","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597593,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Proteins","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597594,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Blood","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597595,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Bilirubin","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597596,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"Urobilinogen Phenlpyruvic acid","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":597597,"parentLabNo":597590,"requestingClinician":"DOCTOR DING RING",
                "investigation":"pH","requestDate":"2014-10-15 08:35:40","orderStage":"op","patientVisitNumber":647692,"patient":{"id":305368,
                "fullName":"SRIRACHA SAUCE SECRET","dateOfBirth":"1952-07-22 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"","city":null}}');

        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546726,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "BS for mps",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 564436,
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
            }');


        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546730,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "Direct Coombs test",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 564436,
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
            }');

        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546728,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "Pregnancy test",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "op",
                "patientVisitNumber": 564436,
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
            }');

        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546727,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "HB",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "ip",
                "patientVisitNumber": 564436,
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
            }');

        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546729,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "Salmonella antigen test",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "ip",
                "patientVisitNumber": 564436,
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
            }');

        $this->labRequestJsonSimpleTestTwoVisits[] = 
            json_decode('{"cost": null,
                "receiptNumber": null,
                "receiptType": null,
                "labNo": 546729,
                "parentLabNo": 0,
                "requestingClinician": "sAM  mAKAL",
                "investigation": "Indirect coombs test",
                "requestDate": "2014-10-14 10:43:39",
                "orderStage": "ip",
                "patientVisitNumber": 564436,
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
            }');
    }
}