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
			'test_category_id' => '1',
			'prevalence_threshold' => 'Whatisdis',
			'measures' => ['1','2', '3','5'],
			'specimentypes' =>  ['1'],
		);

		// Edition sample data
		$this->testTypeDataUpdate = array(
			'name' => 'BS for MPS aka Malaria yo',
			'description' => 'Blood Smears',
			'targetTAT' => '20',
			'test_category_id' => '1',
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
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();

    	//5 because we have seeded five entry already so the next insert gets id 5 
		$testTypeSaved = TestType::find($testTypestored[0]['id']);

		$this->assertEquals($testTypeSaved->name , $this->testTypeData['name']);
		$this->assertEquals($testTypeSaved->description , $this->testTypeData['description']);
		$this->assertEquals($testTypeSaved->targetTAT , $this->testTypeData['targetTAT']);
		$this->assertEquals($testTypeSaved->prevalence_threshold , $this->testTypeData['prevalence_threshold']);
		$this->assertEquals($testTypeSaved->test_category_id , $this->testTypeData['test_category_id']);

		//Getting the Measure related to this test type
		$testTypeMeasure = $testTypeSaved->measures->toArray();
		$this->assertEquals($testTypeMeasure[0]['id'], $this->testTypeData['measures'][0]);
		$this->assertEquals($testTypeMeasure[1]['id'], $this->testTypeData['measures'][1]);
		$this->assertEquals($testTypeMeasure[2]['id'], $this->testTypeData['measures'][2]);
		$this->assertEquals($testTypeMeasure[3]['id'], $this->testTypeData['measures'][3]);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenType = $testTypeSaved->specimenTypes->toArray();
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
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();


    	Input::replace($this->testTypeDataUpdate);
    	$testType->update($testTypestored[0]['id']);

		$testTypeSavedUpdated = TestType::find($testTypestored[0]['id']);
		$this->assertEquals($testTypeSavedUpdated->name , $this->testTypeDataUpdate['name']);
		$this->assertEquals($testTypeSavedUpdated->description , $this->testTypeDataUpdate['description']);
		$this->assertEquals($testTypeSavedUpdated->targetTAT , $this->testTypeDataUpdate['targetTAT']);
		$this->assertEquals($testTypeSavedUpdated->prevalence_threshold , $this->testTypeDataUpdate['prevalence_threshold']);
		$this->assertEquals($testTypeSavedUpdated->test_category_id , $this->testTypeDataUpdate['test_category_id']);
		
		$testTypeMeasureUpdated = TestType::find($testTypestored[0]['id'])->measures->toArray();
		$this->assertEquals($testTypeMeasureUpdated[0]['id'], $this->testTypeDataUpdate['measures'][0]);
		$this->assertEquals($testTypeMeasureUpdated[1]['id'], $this->testTypeDataUpdate['measures'][1]);
		$this->assertEquals($testTypeMeasureUpdated[2]['id'], $this->testTypeDataUpdate['measures'][2]);
		$this->assertEquals($testTypeMeasureUpdated[3]['id'], $this->testTypeDataUpdate['measures'][3]);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenTypeUpdated = TestType::find($testTypestored[0]['id'])->specimenTypes->toArray();
		
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
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();


		$testType = new TestTypeController;
    	$testType->delete($testTypestored[0]['id']);
    	
		$testTypeSaved = TestType::withTrashed()->find($testTypestored[0]['id']);
		$this->assertNotNull($testTypeSaved->deleted_at);
	}

    public function testGetTestTypeIdByTestName()
    {
        Input::replace($this->testTypeData);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testType = new TestType();
        $testTypeID = $testType->getTestTypeIdByTestName($testTypestored[0]['name']);

        $this->assertEquals( $testTypestored[0]['id'], $testTypeID);
    }

}