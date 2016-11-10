<?php

class RequireVerificationTest extends TestCase 
{

	public function setUp(){
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}


	public function setVariables(){
		$this->inputVerifiedAlways = [
			'verify' => '1',
			'always' => '1',
		];

		$this->inputVerifiedRestricted = [
			'verify' => '1',
			'time_from' => '6:00 PM',
			'time_to' => '6:00 AM',
		];

		$this->inputSendAll = [
			'verify' => '0',
		];
	}

	public function testVerifiedAlways(){

		$this->runUpdateVerification($this->inputVerifiedAlways);
		$requireVerification = RequireVerification::get()->first();
		$this->assertEquals($requireVerification->allowProbativeResults(),false);
	}

	public function testVerifiedRestricted(){

		$this->runUpdateVerification($this->inputVerifiedRestricted);
		$requireVerification = RequireVerification::get()->first();
		$this->assertEquals($requireVerification->allowProbativeResults(), true);
	}

	public function testVerifyUneccesary(){

		$this->runUpdateVerification($this->inputSendAll);
		$requireVerification = RequireVerification::get()->first();
		$this->assertEquals($requireVerification->allowProbativeResults(), true);
	}

	public function runUpdateVerification($input){

		Input::replace($input);
		$requireVerification = new RequireVerificationController;
		$requireVerification->Update();
	}
}