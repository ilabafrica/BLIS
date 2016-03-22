<?php
/**
 * Tests the SpecimenRejectionController functions that store, edit and delete specimen rejection reason 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\RejectionReason;
use App\Http\Controllers\SpecimenRejectionController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class SpecimenRejectionControllerTest extends TestCase 
{
	use WithoutMiddleware;
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
		// Store the Rejection Reason
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->take(1)->get()->toArray();

		$rejectionReasonSaved = RejectionReason::find($rejectionReasonstored[0]['id']);
		$this->assertEquals($rejectionReasonSaved->reason , $this->rejectionReasonData['reason']);
	}

	/**
	 * Tests the update function in the SpecimenRejectionController
	 */
	public function testUpdate()
	{
		// Update the SpecimenRejection
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->take(1)->get()->toArray();

		$this->call('PUT', '/specimenrejection/'.$rejectionReasonstored[0]['id'], $this->rejectionReasonUpdate);

		$this->assertEquals($rejectionReasonSaved->reason , $this->rejectionReasonUpdate['reason']);
	}

	/**
	 * Tests the update function in the SpecimenRejectionController
	 */
	public function testDelete()
	{
		$this->call('POST', '/specimenrejection', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->take(1)->get()->toArray();

		$this->call('DELETE', '/specimenrejection/'.$rejectionReasonstored[0]['id'], $this->rejectionReasonData);

		$rejectionReasonDeleted = RejectionReason::withTrashed()->find($rejectionReasonstored[0]['id']);
		$this->assertNotNull($rejectionReasonDeleted);
	}
}