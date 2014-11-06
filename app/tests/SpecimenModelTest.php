<?php

class SpecimenModelTest extends TestCase {
    
    public function setup()
    {
        parent::setup();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testIsReferred()
    {
        $specimen = Specimen::find(1);

    }

}