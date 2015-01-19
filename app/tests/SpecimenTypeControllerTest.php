<?php
/**
 * Tests the SpecimenTypeController functions that store, edit and delete specimenTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
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

        Input::replace($this->specimenData);
        $specimenType = new SpecimenTypeController;
        $specimenType->store();
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
        Input::replace($this->specimenData);
        $specimenType = new SpecimenTypeController;
        $specimenType->store();
		$specimenTypestored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();

        Input::replace($this->specimenDataUpdate);
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
        Input::replace($this->specimenData);
        $specimenType = new SpecimenTypeController;
        $specimenType->store();
		$specimenTypestored = SpecimenType::orderBy('id','desc')->take(1)->get()->toArray();

        $specimenType->delete($specimenTypestored[0]['id']);

		$specimenTypesDeleted = SpecimenType::withTrashed()->find($specimenTypestored[0]['id']);
		$this->assertNotNull($specimenTypesDeleted->deleted_at);
	}
}