<?php
/**
 * Tests the TestTypeController functions that store, edit and delete testTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestTypeControllerTest extends TestCase 
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
	 * Contains the testing sample data for the TestTypeController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
		// Initial sample storage data
		$this->testTypeData = array(
			'name' => 'BSforMPS',
			'description' => 'Blood Smear',
			'targetTAT' => '25',
			'section_id' => '1',
			'prevalence_threshold' => 'Whatisdis',
			'measures' => ['1','2', '3','5'],
			'specimentypes' =>  ['1'],
		);

		// Edition sample data
		$this->testTypeDataUpdate = array(
			'name' => 'BS for MPS aka Malaria yo',
			'description' => 'Blood Smears',
			'targetTAT' => '20',
			'section_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'measures' => ['1','2', '5','6'],
			'specimentypes' =>  ['1'],
		);
    }
	
	/**
	 * Tests the store function in the TestTypeController
	 * @param  testing Sample from the constructor
	 * @return array $testTypeId IDs of TestTypes stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
  		echo "\n\nTEST TYPE CONTROLLER TEST\n\n";
  		 // Store the TestType Types
  		Input::replace($this->testTypeData);
    	$testType = new TestTypeController;
    	$testType->store();

    	//2 because we have seeded one entry already so the next insert gets id 2
		$testTypeSaved = TestType::find(13);

		$this->assertEquals($testTypeSaved->name , $this->testTypeData['name']);
		$this->assertEquals($testTypeSaved->description , $this->testTypeData['description']);
		$this->assertEquals($testTypeSaved->targetTAT , $this->testTypeData['targetTAT']);
		$this->assertEquals($testTypeSaved->prevalence_threshold , $this->testTypeData['prevalence_threshold']);
		$this->assertEquals($testTypeSaved->section_id , $this->testTypeData['section_id']);

		//Getting the Measure related to this test type
		$testTypeMeasure = TestType::find(13)->measures->toArray();
		$this->assertEquals($testTypeMeasure[0]['id'], $this->testTypeData['measures'][0]);
		$this->assertEquals($testTypeMeasure[1]['id'], $this->testTypeData['measures'][1]);
		$this->assertEquals($testTypeMeasure[2]['id'], $this->testTypeData['measures'][2]);
		$this->assertEquals($testTypeMeasure[3]['id'], $this->testTypeData['measures'][3]);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenType = TestType::find(13)->specimenTypes->toArray();
		$this->assertEquals($testTypeSpecimenType[0]['id'], $this->testTypeData['specimentypes'][0]);
  	}

  	/**
  	 * Tests the update function in the TestTypeController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{

		Input::replace($this->testTypeData);
    	$testType = new TestTypeController;
    	$testType->store();

    	Input::replace($this->testTypeDataUpdate);
    	$testType->update(2);

		$testTypeSavedUpdated = TestType::find(2);
		$this->assertEquals($testTypeSavedUpdated->name , $this->testTypeDataUpdate['name']);
		$this->assertEquals($testTypeSavedUpdated->description , $this->testTypeDataUpdate['description']);
		$this->assertEquals($testTypeSavedUpdated->targetTAT , $this->testTypeDataUpdate['targetTAT']);
		$this->assertEquals($testTypeSavedUpdated->prevalence_threshold , $this->testTypeDataUpdate['prevalence_threshold']);
		$this->assertEquals($testTypeSavedUpdated->section_id , $this->testTypeDataUpdate['section_id']);
		
		$testTypeMeasureUpdated = TestType::find(2)->measures->toArray();
		$this->assertEquals($testTypeMeasureUpdated[0]['id'], $this->testTypeDataUpdate['measures'][0]);
		$this->assertEquals($testTypeMeasureUpdated[1]['id'], $this->testTypeDataUpdate['measures'][1]);
		$this->assertEquals($testTypeMeasureUpdated[2]['id'], $this->testTypeDataUpdate['measures'][2]);
		$this->assertEquals($testTypeMeasureUpdated[3]['id'], $this->testTypeDataUpdate['measures'][3]);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenTypeUpdated = TestType::find(2)->specimenTypes->toArray();
		
		$this->assertEquals($testTypeSpecimenTypeUpdated[0]['id'], $this->testTypeDataUpdate['specimentypes'][0]);
	}
	
	/**
  	 * Tests the update function in the TestTypeController
	 * @param void
	 * @return void
     */
	public function testDelete()
	{
		Input::replace($this->testTypeData);
    	$testType = new TestTypeController;
    	$testType->store();

		$testType = new TestTypeController;
    	$testType->delete(2);
    	
		$testTypeSaved = TestType::withTrashed()->find(2);
		$this->assertNotNull($testTypeSaved->deleted_at);
	}

    public function testGetTestTypeIdByTestName()
    {
        $testType = new TestType();
        $bSforMPSTestTypeID = $testType->getTestTypeIdByTestName("BS for MPS");
        $gXMTestTypeID = $testType->getTestTypeIdByTestName("GXM");

        $this->assertEquals( 1, $bSforMPSTestTypeID);
        $this->assertEquals( 2, $gXMTestTypeID );
    }

}