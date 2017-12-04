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
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'Whatisdis',
			'specimentypes' =>  ['1'],
			'orderable_test' => '1',
			'new-measures' => [
				'1' => [
					'name' => 'CSFforBiochemistry',
					'measure_type_id' => '4',
					'unit' => 'Unit',
					'description' => 'Description'
				],
			],
		);

		// Edition sample data
		$this->testTypeDataUpdate = array(
			'name' => 'BS for MPS aka Malaria yo',
			'description' => 'Blood Smears',
			'targetTAT' => '20',
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'specimentypes' =>  ['1'],
			'orderable_test' => '1',
			'new-measures' => [
				'1' => [
					'name' => 'FreeText',
					'measure_type_id' => '4',
					'unit' => 'fUnit',
					'description' => 'fDescription'
				],
			],
		);

		// Trailing space sample data
		$this->testTypeTrailingSpace = array(
			'name' => 'Culture for sensitivity ',
			'description' => 'blaaa ',
			'targetTAT' => '20',
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'specimentypes' =>  ['1'],
			'new-measures' => [
				'1' => [
					'name' => 'FreeText',
					'measure_type_id' => '4',
					'unit' => 'fUnit',
					'description' => 'fDescription'
				],
			],
		);

		// Leading sample data
		$this->testTypeLeadingSpace = array(
			'name' => ' Culture for sensitivity',
			'description' => 'blaa ',
			'targetTAT' => '20',
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'specimentypes' =>  ['1'],
			'new-measures' => [
				'1' => [
					'name' => 'FreeText',
					'measure_type_id' => '4',
					'unit' => 'fUnit',
					'description' => 'fDescription'
				],
			],
		);

		// Trailing Leading sample data
		$this->testTypeLeadingTrailingSpace = array(
			'name' => ' Culture for sensitivity ',
			'description' => 'blaa ',
			'targetTAT' => '20',
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'specimentypes' =>  ['1'],
			'new-measures' => [
				'1' => [
					'name' => 'FreeText',
					'measure_type_id' => '4',
					'unit' => 'fUnit',
					'description' => 'fDescription'
				],
			],
		);

		// Trailing space sample data
		$this->testTypeNoTrailingLeadingSpace = array(
			'name' => 'Culture for sensitivity',
			'description' => 'blaaa ',
			'targetTAT' => '20',
			'paneltypes'  =>['1'],
			'test_category_id' => '1',
			'prevalence_threshold' => 'ffffffffffuuuuuuuuuu',
			'specimentypes' =>  ['1'],
			'new-measures' => [
				'1' => [
					'name' => 'FreeText',
					'measure_type_id' => '4',
					'unit' => 'fUnit',
					'description' => 'fDescription'
				],
			],
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
        //dd($testTypestored);
		$testTypeSaved = TestType::find($testTypestored[0]['id']);

		$this->assertEquals($testTypeSaved->name , $this->testTypeData['name']);
		$this->assertEquals($testTypeSaved->description , $this->testTypeData['description']);
		$this->assertEquals($testTypeSaved->targetTAT , $this->testTypeData['targetTAT']);
		$this->assertEquals($testTypeSaved->prevalence_threshold , $this->testTypeData['prevalence_threshold']);		
		$this->assertEquals($testTypeSaved->test_category_id , $this->testTypeData['test_category_id']);


		//Getting the Measure related to this test type
		$testTypeMeasure = $testTypeSaved->measures->toArray();
		$this->assertEquals($testTypeMeasure[0]['name'], $this->testTypeData['new-measures'][1]['name']);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenType = $testTypeSaved->specimenTypes->toArray();
		$this->assertEquals($testTypeSpecimenType[0]['id'], $this->testTypeData['specimentypes'][0]);

		//Getting the Panel type related to this test type
		$testTypePanelType = $testTypeSaved->Panel->toArray();
		$this->assertEquals($testTypePanelType[0]['id'], $this->testTypeData['paneltypes'][0]);

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
		$this->assertEquals($testTypeMeasureUpdated[0]['name'], $this->testTypeDataUpdate['new-measures'][1]['name']);

		//Getting the Specimen type related to this test type
		$testTypeSpecimenTypeUpdated = TestType::find($testTypestored[0]['id'])->specimenTypes->toArray();
		
		$this->assertEquals($testTypeSpecimenTypeUpdated[0]['id'], $this->testTypeDataUpdate['specimentypes'][0]);

		//Getting the Panel type related to this test type
		$testTypePanelTypeUpdated = TestType::find($testTypestored[0]['id'])->Panel->toArray();
		
		$this->assertEquals($testTypePanelTypeUpdated[0]['id'], $this->testTypeDataUpdate['paneltypes'][0]);
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

    public function testGetTestTypeIdByTestNameLeadingSpace()
    {
        Input::replace($this->testTypeTrailingSpace);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testType = new TestType();
        $testTypeID = $testType->getTestTypeIdByTestName('Culture for sensitivity');

        $this->assertEquals( $testTypestored[0]['id'], $testTypeID);
    }

    public function testGetTestTypeIdByTestNameTrailingSpace()
    {
        Input::replace($this->testTypeLeadingSpace);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testType = new TestType();
        $testTypeID = $testType->getTestTypeIdByTestName('Culture for sensitivity');

        $this->assertEquals( $testTypestored[0]['id'], $testTypeID);
    }

    public function testGetTestTypeIdByTestNameLeadingTrailingSpace()
    {
        Input::replace($this->testTypeLeadingTrailingSpace);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testType = new TestType();
        $testTypeID = $testType->getTestTypeIdByTestName('Culture for sensitivity');

        $this->assertEquals( $testTypestored[0]['id'], $testTypeID);
    }

    public function testGetTestTypeIdByTestNameWithTrailingLeadingSpaces()
    {
        Input::replace($this->testTypeNoTrailingLeadingSpace);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testType = new TestType();
        $testTypeID = $testType->getTestTypeIdByTestName(' Culture for sensitivity ');

        $this->assertEquals( $testTypestored[0]['id'], $testTypeID);
    }

    //	Test the countPerStatus method
    public function testCountPerStatus()
    {
        Input::replace($this->testTypeData);
    	$testType = new TestTypeController;
    	$testType->store();
		$testTypestored = TestType::orderBy('id','desc')->take(1)->get()->toArray();
        $testTypeSaved = TestType::find($testTypestored[0]['id']);
        $count = $testTypeSaved->countPerStatus([Test::NOT_RECEIVED, Test::STARTED, Test::PENDING, Test::COMPLETED, Test::VERIFIED]);

        $this->assertEquals( $testTypeSaved->tests->count(), $count);
    }

}