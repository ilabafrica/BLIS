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
		$response = $this->action('POST', 'SpecimenRejectionController@store', $this->rejectionReasonData);
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
		$response = $this->action('POST', 'SpecimenRejectionController@store', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->take(1)->get()->toArray();

		$response = $this->action('PUT', 'SpecimenRejectionController@update', $this->rejectionReasonUpdate);
		$rejectionReason->update($rejectionReasonstored[0]['id']);

		$this->assertEquals($rejectionReasonSaved->reason , $this->rejectionReasonUpdate['reason']);
	}

	/**
	 * Tests the update function in the SpecimenRejectionController
	 */
	public function testDelete()
	{
		$response = $this->action('POST', 'SpecimenRejectionController@store', $this->rejectionReasonData);
		$rejectionReasonstored = RejectionReason::orderBy('id','desc')->take(1)->get()->toArray();

		$rejectionReason->delete($rejectionReasonstored[0]['id']);

		$rejectionReasonDeleted = RejectionReason::find($rejectionReasonstored[0]['id']);
		$this->assertNull($rejectionReasonDeleted);
	}
}