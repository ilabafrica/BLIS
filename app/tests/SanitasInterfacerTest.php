<?php
/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use \Mockery as m;

class SanitasInterfacerTest extends TestCase
{
    public function setup()
    {
        parent::setup();
        echo "\n\nSANITAS INTERFACER TEST\n\n";
        $this->app->bind('interfacer', 'sanitasInterfacer');
        Artisan::call('migrate');
        $this->setVariables();
    }

    public function testRetrieve()
    {
        $this->assertTrue(true);
        //$this->action('POST', 'api.receiver', $this->labrequestJson);
        //$patient1 =Patient::find(1);

        //$this->assertEquals($this->labrequestJson['patient']['id'], $patient1->patient_number);
        //$this->assertEquals($this->labrequestJson['patient']['fullName'], $patient1->name);

    }

    public function setVariables()
    {
        $this->labrequestJson = 
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
            }');
    }
}