<?php

class PatientModelTest extends TestCase {
    
    function setup()
    {
        parent::setup();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testGetGender()
    {
        $patient2 = Patient::find(2);
        $patient3 = Patient::find(3);

        $this->assertEquals('F', $patient2->getGender());
        $this->assertEquals('M', $patient3->getGender());

    }
}