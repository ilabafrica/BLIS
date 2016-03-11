<?php

use App\Models\Referral;
use App\Models\Specimen;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class SpecimenModelTest extends TestCase {
    
    use WithoutMiddleware;
    public function setup()
    {
        parent::setup();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    public function testIsReferred()
    {
        //Insert into referral table
        $referral = new Referral();
        $referral->status = Referral::REFERRED_IN;
        $referral->facility_id = 1;
        $referral->person = "Gentrix";
        $referral->contacts = "Saville Row : London";
        $referral->user_id = 1;

        $specimen = Specimen::find(1);
        $referral->save();
        $specimen->referral_id = $referral->id;
        $specimen->save();

        $this->assertEquals($specimen->isReferred(), true);
    }

    public function testIsNotReferred()
    {
        $specimen = Specimen::find(1);
        $this->assertEquals($specimen->isReferred(), false);
    }

    public function testIsRejected()
    {
        $specimenRejected = Specimen::where('specimen_status_id', '=', Specimen::REJECTED)->first();

        $this->assertEquals($specimenRejected->isRejected(), true);
    }

    public function testIsNotRejected()
    {
        $specimenRejected = Specimen::where('specimen_status_id', '!=', Specimen::REJECTED)->first();

        $this->assertEquals($specimenRejected->isRejected(), false);
    }

}