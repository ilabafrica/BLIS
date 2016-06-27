<?php
/**
 * Tests the SpecimenRejectionController functions that store, edit and delete specimen rejection reason 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\RejectionReason;
use App\Http\Controllers\SpecimenRejectionController;

class SpecimenRejectionControllerTest extends TestCase 
{
	
	/**
	 * Initial setup function for tests
	 */
	public function setUp(){
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}

	/**
	 * Contains the testing sample data for the SpecimenRejectionController.
	 */
	public function setVariables()
	{
		// Initial sample storage data
		$this->rejectionReasonData = array(
			'reason' => 'oldreason',
		);

		// Edition sample data
		$this->rejectionReasonUpdate = array(
			'reason' => 'newreason',
		);
	}
	
	/**
	 * Tests the store function in the SpecimenRejectionController
	 */
 	public function testStore() 
	{
		echo "\n\nTEST SPECIMEN REJECTION CONTROLLER TEST\n\n";
		$this->withoutMiddleware();
		// Store the Rejection Reason
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->first();

		$rejectionReasonSaved = RejectionReason::find($rejectionReasonstored->id);
		$this->assertEquals($rejectionReasonSaved->reason , $this->rejectionReasonData['reason']);
	}

	/**
	 * Tests the update function in the SpecimenRejectionController
	 */
	// todo: check the logic, log values of variables to see the problem
	public function testUpdate()
	{
		$this->withoutMiddleware();
		// Update the SpecimenRejection
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/specimenrejection/'.$rejectionReasonstored->id, $this->rejectionReasonUpdate);
		$rejectionReasonSaved = RejectionReason::orderBy('id','desc')->first();
		$this->assertEquals($rejectionReasonSaved->reason , $this->rejectionReasonUpdate['reason']);
	}

	/**
	 * Tests the update function in the SpecimenRejectionController
	 */
	public function testDelete()
	{
		$this->withoutMiddleware();
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->first();

		$this->call('DELETE', '/specimenrejection/'.$rejectionReasonstored->id, $this->rejectionReasonData);

		$rejectionReasonDeleted = RejectionReason::withTrashed()->find($rejectionReasonstored->id);
		$this->assertNotNull($rejectionReasonDeleted->deleted_at);
	}
}