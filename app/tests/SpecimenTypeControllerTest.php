<?php
/**
 * Tests the SpecimenTypeController functions that store, edit and delete specimenTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class SpecimenTypeControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the SpecimenTypeController.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	// Initial sample storage data
		$this->input = array(
			'name' => 'SynovialFlud',
			'description' => 'Lets see!',
		);

		// Edition sample data
		$this->inputUpdate = array(
			'name' => 'SynovialFluid',
			'description' => 'Honestly have no idea',
		);

		$this->testSpecimenTypeId = NULL;
    }
	
	/**
	 * Tests the store funtion in the SpecimenTypeController
	 * @param  testing Sample from the constructor
	 * @return int $testSpecimenTypeId ID of SpecimenType stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nSPECIMEN TYPE CONTROLLER TEST\n\n";
  		 // Store the SpecimenTypes
		$this->runStore($this->input);

		$specimenTypesSaved = SpecimenType::orderBy('id','desc')->take(1)->get();
		foreach ($specimenTypesSaved as $specimenTypeSaved) {
			$this->testSpecimenTypeId = $specimenTypeSaved->id;
			$this->assertEquals($specimenTypeSaved->name , $this->input['name']);
			$this->assertEquals($specimenTypeSaved->description ,$this->input['description']);
			$testSpecimenTypeId = $this->testSpecimenTypeId;
		}
		echo "SpecimenType created\n";
		return $testSpecimenTypeId;
  	}

  	/**
  	 * Tests the update funtion in the SpecimenTypeController
     * @depends testStore
	 * @param  int $testSpecimenTypeId SpecimenType ID from testStore(), testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testSpecimenTypeId)
	{
		// Update the SpecimenTypes
		$this->runUpdate($this->inputUpdate, $testSpecimenTypeId);

		$specimenTypesSaved = SpecimenType::orderBy('id','desc')->take(1)->get();
		foreach ($specimenTypesSaved as $specimenTypeSaved) {
			$this->assertEquals($specimenTypeSaved->name , $this->inputUpdate['name']);
			$this->assertEquals($specimenTypeSaved->description ,$this->inputUpdate['description']);
		}
		echo "\nSpecimenType updated\n";
	}

	/**
  	 * Tests the update funtion in the SpecimenTypeController
     * @depends testStore
	 * @param  int $testSpecimenTypeId SpecimenType ID from testStore()
	 * @return void
     */
	public function testDelete($testSpecimenTypeId)
	{
		$this->runDelete($testSpecimenTypeId);
		$specimenTypesSaved = SpecimenType::withTrashed()->orderBy('id','desc')->take(1)->get();
		foreach ($specimenTypesSaved as $specimenTypeSaved) {
			$this->assertNotNull($specimenTypeSaved->deleted_at);
	    }
		echo "\nSpecimenType softDelete\n";
	    $this->removeTestData($testSpecimenTypeId);
		echo "sample SpecimenType removed from the Database\n";
	}
	
	
  	/**
  	 *Executes the store funtion in the SpecimenTypeController
  	 * @param  array $input SpecimenType details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
    	$specimenType = new SpecimenTypeController;
    	$specimenType->store();
	}

  	/**
  	 * Executes the update funtion in the SpecimenTypeController
  	 * @param  array $input SpecimenType details, int $id ID of the SpecimenType stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$specimenType = new SpecimenTypeController;
    	$specimenType->update($id);
	}

	/**
	 * Executes the delete funtion in the SpecimenTypeController
	 * @param  int $id ID of SpecimenType stored
	 * @return void
	 */
	public function runDelete($id)
	{
		$specimenType = new SpecimenTypeController;
    	$specimenType->delete($id);
	}

	 /**
	  * Force delete all sample SpecimenTypes from the database
	  * @param  int $id SpecimenType ID
	  * @return void
	  */
	public function removeTestData($id)
	{
		DB::table('specimen_types')->delete($id);
	}
}