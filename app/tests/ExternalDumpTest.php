<?php

/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

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
        //Sending requests for urinalysis
        for ($i=0; $i < count($this->labRequestUrinalysis); $i++) { 
            Interfacer::retrieve($this->labRequestUrinalysis[$i]);
        }

        $externalDump = new ExternalDump();
        $externalDumpTree = $externalDump->getLabRequestAndMeasures($this->labRequestUrinalysis[0]['labNo']);

        $this->assertTrue(count($externalDumpTree) == 19);
        $this->assertEquals($externalDumpTree->first()->labNo, 596699);
        $this->assertEquals($externalDumpTree->last()->labNo, 596717);
    }

    //BS for MPS
    public function testGetSimpleTestRequestTree()
    {
        $this->call('POST', 'api/receiver', $this->labRequestJsonSimpleTest, 
                array(), array(), array('application/json'));

        $externalDump = new ExternalDump();
        $externalDumpTree = $externalDump->getLabRequestAndMeasures($this->labRequestJsonSimpleTest['labNo']);

        $this->assertTrue(count($externalDumpTree) == 1);
        $this->assertEquals($externalDumpTree->first()->labNo, $this->labRequestJsonSimpleTest['labNo']);
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

        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596699,"parentLabNo":0,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urinalysis",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596700,"parentLabNo":596699,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urine microscopy",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596701,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Pus cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596702,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"S. haematobium",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596703,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"T. vaginalis",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596704,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Yeast cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596705,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Red blood cells",
                "requestDate":"2014-10-14 10:20:35","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596706,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Bacteria",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596707,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Spermatozoa",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596708,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Epithelial cells",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596709,"parentLabNo":596700,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"ph",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596710,"parentLabNo":596699,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urine chemistry",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596711,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Glucose",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596712,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Ketones",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596713,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Proteins",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596714,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Blood",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596715,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Bilirubin",
                "requestDate":"2014-10-14 10:20:36","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596716,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"Urobilinogen Phenlpyruvic acid",
                "requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
        $this->labRequestUrinalysis[] = 
            json_decode('{"cost":null,"receiptNumber":null,"receiptType":null,"labNo":596717,"parentLabNo":596710,
                "requestingClinician":"FELA ANIKULAPO KUTI","investigation":"pH",
                "requestDate":"2014-10-14 10:20:37","orderStage":"ip","patientVisitNumber":643660,
                "patient":{"id":326983,"fullName":"Nate Salman","dateOfBirth":"1996-10-09 00:00:00","gender":"Female"},
                "address":{"address":null,"postalCode":null,"phoneNumber":"","city":null}}',true);
    }
}