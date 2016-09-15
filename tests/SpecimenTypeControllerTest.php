<?php
/**
 * Tests the SpecimenTypeController functions that store, edit and delete specimenTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Specimen;
use App\Models\SpecimenType;
use App\Http\Controllers\SpecimenTypeController;

class SpecimenTypeControllerTest extends TestCase 
{
	
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

		$this->withoutMiddleware();
		$this->call('POST', '/specimentype', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->first();

		$specimenTypesSaved = SpecimenType::find($specimenTypestored->id);
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
		$this->withoutMiddleware();
		$this->call('POST', '/specimentype', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/specimentype/'.$specimenTypestored->id, $this->specimenDataUpdate);

		$specimenTypeUpdated = SpecimenType::find($specimenTypestored->id);
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
		$this->withoutMiddleware();
		$this->call('POST', '/specimentype', $this->specimenData);
		$specimenTypestored = SpecimenType::orderBy('id','desc')->first();
		// todo: use destroy and remove such : /specimentype/{id}/delete
		$this->call('DELETE', '/specimentype/'.$specimenTypestored->id.'/delete', $this->specimenData);

		$specimenTypesDeleted = SpecimenType::withTrashed()->find($specimenTypestored->id);
		$this->assertNotNull($specimenTypesDeleted->deleted_at);
	}
	//	Test the countPerStatus method in Specimen Type
    public function specimenCountPerStatus()
    {
		$this->withoutMiddleware();
		$this->call('POST', '/specimentype', $this->specimenData);
		$specimenTypeStored = SpecimenType::orderBy('id','desc')->first();
        $specimenTypeSaved = SpecimenType::find($specimenTypeStored->id);
        $count = $specimenTypeSaved->countPerStatus([Specimen::ACCEPTED, Specimen::REJECTED, Specimen::NOT_COLLECTED]);

        $this->assertEquals( $specimenTypeSaved->specimen->count(), $count);
    }
}