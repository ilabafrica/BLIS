<?php

use App\Models\Patient;

class PatientModelTest extends TestCase {
    
    
    public function setup()
    {
        parent::setup();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testGetGender()
    {
        $data = array(
            //the first array is saved last
            array(
                'patient_number' => '6666',
                'name' => 'Paul Mamboleo',
                'dob' => '1930-07-05',
                'gender' => '0',//male
                'email' => 'mambo@saharara.com',
                'address' => 'Godric Hollows',
                'phone_number' => '+189012402938',
                'created_at' => '0000-00-00',
                'updated_at' => '0000-00-00',
            ),
            //the last array is saved first
            array(
                'patient_number' => '5555',
                'name' => 'Akellus Judith Pocos Black',
                'dob' => '1900-07-05',
                'gender' => '1',//female
                'email' => 'buildandt@saharara.com',
                'address' => '12 Grimmauld Place',
                'phone_number' => '+18966602938',
                'created_at' => '0000-00-00',
                'updated_at' => '0000-00-00',
            ),
        );

        Patient::insert($data);
        $patientSaved = Patient::orderBy('id','desc')->take(2)->get()->toArray();

        $patientfemale = Patient::find($patientSaved[1]['id']);
        $patientmale = Patient::find($patientSaved[0]['id']);

        $this->assertEquals('F', $patientfemale->getGender());
        $this->assertEquals('M', $patientmale->getGender());

    }
}