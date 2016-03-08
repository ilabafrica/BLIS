<?php

/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Api\SanitasInterfacer;
use App\Api\Facades\Interfacer;

class ExternalDumpTest extends TestCase
{
    public function setup()
    {
        parent::setup();
        $this->app->bind('Interfacer', 'SanitasInterfacer');
        Artisan::call('migrate');
        $this->setVariables();
    }

    //Urinalysis
    public function testGetComplexLabRequestAndMeasuresTree()
    {
        echo "\n\nEXTERNAL DUMP MODEL TEST\n\n";

        $requestCount = count($this->labRequestUrinalysis);
        //Sending requests for urinalysis
        for ($i=0; $i < $requestCount; $i++) { 
            Interfacer::retrieve($this->labRequestUrinalysis[$i]);
        }

        $externalDump = new ExternalDump();
        $externalDumpTree = $externalDump->getLabRequestAndMeasures($this->labRequestUrinalysis{0}->labNo);
        $this->assertEquals(count($externalDumpTree), $requestCount-1); //The number of requests for urinalysis
        $this->assertEquals($externalDumpTree->first()->lab_no, $this->labRequestUrinalysis{1}->labNo);
        $this->assertEquals($externalDumpTree->last()->lab_no, $this->labRequestUrinalysis{$requestCount-1}->labNo);
    }

    //BS for MPS
    public function testGetSimpleTestRequestTree()
    {
        $this->call('POST', 'api/receiver', array(), 
                array(), array(), $this->labRequestJsonSimpleTest);

        $externalDump = new ExternalDump();
        $labR = json_decode($this->labRequestJsonSimpleTest);
        $externalDumpTree = $externalDump->getLabRequestAndMeasures($labR->labNo);

        $this->assertEquals(count($externalDumpTree), 0); //1 request
    }

    public function setVariables()
    {

        $this->labRequestJsonSimpleTest = '{"cost": null,
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
            }';//When TRUE, returned objects will be converted into associative arrays.

        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":100,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596906,"parentLabNo":0,"requestingClinician":"TEST DOCTOR",
                "investigation":"Urinalysis","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596907,"parentLabNo":596906,"requestingClinician":"TEST DOCTOR",
                "investigation":"Urine microscopy","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596908,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Pus cells","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596909,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"S. haematobium","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596910,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"T. vaginalis","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596911,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Yeast cells","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596912,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Red blood cells","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596913,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Bacteria","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596914,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Spermatozoa","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596915,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"Epithelial cells","requestDate":"2014-10-14 12:09:52","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596916,"parentLabNo":596907,"requestingClinician":"TEST DOCTOR",
                "investigation":"ph","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596917,"parentLabNo":596906,"requestingClinician":"TEST DOCTOR",
                "investigation":"Urine chemistry","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596918,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Glucose","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596919,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Ketones","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596920,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Proteins","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596921,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Blood","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596922,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Bilirubin","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596923,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"Urobilinogen Phenlpyruvic acid","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":0,"receiptNumber":"RT-1413278436324","receiptType":"standard","labNo":596924,"parentLabNo":596917,"requestingClinician":"TEST DOCTOR",
                "investigation":"pH","requestDate":"2014-10-14 12:09:53","orderStage":"op","patientVisitNumber":647181,"patient":{"id":192404,
                "fullName":"JOHN DOE WAYNE","dateOfBirth":"1982-07-12 00:00:00","gender":"Female"},"address":{"address":null,"postalCode":null,
                "phoneNumber":"254729492952","city":null}}');
    }
}