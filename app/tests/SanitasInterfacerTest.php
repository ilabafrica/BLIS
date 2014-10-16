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

    public function testRetrieve()
    {
        $this->assertTrue(true);
        $this->call('POST', 'api/receiver', $this->labrequestJson, 
                array(), array(), array('application/json'));
        $patient6 =Patient::find(6);

        $this->assertEquals($this->labrequestJson['patient']['id'], $patient6->patient_number);
        $this->assertEquals($this->labrequestJson['patient']['fullName'], $patient6->name);

    }

    public function setVariables()
    {
        $this->labrequestJson = (array)
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
            }', true);
    }
}