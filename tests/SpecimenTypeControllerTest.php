<?php
/**
 * Tests the SpecimenTypeController functions that store, edit and delete specimenTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Specimen;
use App\Models\SpecimenType;
use App\Http\Controllers\SpecimenTypeController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class SpecimenTypeControllerTest extends TestCase 
{
	use WithoutMiddleware;
    /**
     * Initial setup function for tests
     *
     * @return void
     */
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->setVariables();
    }
	/**
	 * Contains the testing sample data for the SpecimenTypeController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
        
    	// Initial sample storage data
		$this->specimenData = array(
			'name' => 'SynovialFlud',
			'description' => 'Lets see!',
		);

		// Edition sample data
		$this->specimenDataUpdate = array(
			'name' => 'SynovialFluid',
			'description' => 'Honestly have no idea',
		);
    }
	
	/**
	 * Tests the store funtion in the SpecimenTypeController
	 * @param  void
	 * @return int $testSpecimenTypeId ID of SpecimenType stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nSPECIMEN TYPE CONTROLLER TEST\n\n";

		$response = $this->action('POST', 'SpecimenTypeController@store', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();

		$specimenTypesSaved = SpecimenType::find($specimenTypestored[0]['id']);
		$this->assertEquals($specimenTypesSaved->name , $this->specimenData['name']);
		$this->assertEquals($specimenTypesSaved->description ,$this->specimenData['description']);
  	}

  	/**
  	 * Tests the update funtion in the SpecimenTypeController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		$response = $this->action('POST', 'SpecimenTypeController@store', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();

		$response = $this->action('PUT', 'SpecimenTypeController@update', $this->specimenDataUpdate);
        $specimenType->update($specimenTypestored[0]['id']);

		$specimenTypeUpdated = SpecimenType::find($specimenTypestored[0]['id']);
		$this->assertEquals($specimenTypeUpdated->name , $this->specimenDataUpdate['name']);
		$this->assertEquals($specimenTypeUpdated->description ,$this->specimenDataUpdate['description']);
	}

	/**
  	 * Tests the update funtion in the SpecimenTypeController
	 * @param  int $testSpecimenTypeId SpecimenType ID from testStore()
	 * @return void
     */
	public function testDelete()
	{
		$response = $this->action('POST', 'SpecimenTypeController@store', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();

        $specimenType->delete($specimenTypestored[0]['id']);

		$specimenTypesDeleted = SpecimenType::withTrashed()->find($specimenTypestored[0]['id']);
		$this->assertNotNull($specimenTypesDeleted->deleted_at);
	}
	//	Test the countPerStatus method in Specimen Type
    public function specimenCountPerStatus()
    {
		$response = $this->action('POST', 'SpecimenTypeController@store', $this->specimenData);
		$specimenTypeStored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();
        $specimenTypeSaved = SpecimenType::find($specimenTypeStored[0]['id']);
        $count = $specimenTypeSaved->countPerStatus([Specimen::ACCEPTED, Specimen::REJECTED, Specimen::NOT_COLLECTED]);

        $this->assertEquals( $specimenTypeSaved->specimen->count(), $count);
    }
}