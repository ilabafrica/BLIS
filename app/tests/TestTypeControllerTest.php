<?php
/**
 * Tests the TestTypeController functions that store, edit and delete testTypes 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestTypeControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the TestTypeController.
	 *
	 * @return void
	 */
    public function __construct()
    {
		$this->testCategoryId = array();
		$this->measureId = array();
		$this->specimenTypeId = array();
		$this->removeTestDataId = array();

		$this->inputTestCategories = array(
			['name' => 'testprasitology',],
			['name' => 'testPARASITOLOGY',],
		);

		$this->inputMeasures = array(
			['measure_type_id' => '2', 'name' =>'BSforMPS', 'measure_range' => '+++/++/+/-'],
			['measure_type_id' => '2', 'name' =>'BSformps', 'measure_range' => '+++/++/+/-'],
			['measure_type_id' => '2', 'name' =>'BSformpS', 'measure_range' => '+++/++/+/-'],
			['measure_type_id' => '2', 'name' =>'BSformPS', 'measure_range' => '+++/++/+/-'],
		);

		$this->inputSpecimenTypes = array(
			['name' =>'wholblood',],
			['name' =>'wholeblood',],
			['name' =>'Wholeblood',],
			['name' =>'WholeBlood',],
		);
		
		// Initial sample storage data
		$this->input = array(
			'name' => 'BSforMPS',
			'description' => 'Blood Smear',
			'targetTAT' => '25',
			'prevalence_threshold' => 'Whatisdis',
		);

		// Edition sample data
		$this->inputUpdate = array(
			'name' => 'BS for MPS',
			'description' => 'Blood Smears',
			'targetTAT' => '20',
			'prevalence_threshold' => 'No ID Ah',
		);

		$this->testTypeId = NULL;
    }
	
	/**
	 * Tests the store function in the TestTypeController
	 * @param  testing Sample from the constructor
	 * @return array $testTypeId IDs of TestTypes stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
  		$testTypeId = array();
  		echo "\n\nTEST TYPE CONTROLLER TEST\n\n";
  		$testCategoryIds = $this->injectTestCategories($this->inputTestCategories);
		$this->testCategoryId['initial'] = $testCategoryIds[0]; 

		$measureIds = $this->injectMeasures($this->inputMeasures);
		$this->measureId['initial'][0] = $measureIds[0]; 
		$this->measureId['initial'][1] = $measureIds[1]; 

		$specimenTypeIds = $this->injectSpecimenTypes($this->inputSpecimenTypes);
		$this->specimenTypeId['initial'][0] = $specimenTypeIds[0]; 
		$this->specimenTypeId['initial'][1] = $specimenTypeIds[1];

		$this->input['section_id'] = $this->testCategoryId['initial'];
		$this->input['measures'] = $this->measureId['initial'];
		$this->input['specimentypes'] = $this->specimenTypeId['initial'];
		
  		 // Store the TestType Types
		$this->runStore($this->input);

		$testTypesSaved = TestType::orderBy('id','desc')->take(1)->get();
		foreach ($testTypesSaved as $testTypeSaved) {
			$this->testTypeId = $testTypeSaved->id;

			$this->assertEquals($testTypeSaved->name , $this->input['name']);
			$this->assertEquals($testTypeSaved->description , $this->input['description']);
			$this->assertEquals($testTypeSaved->targetTAT , $this->input['targetTAT']);
			$this->assertEquals($testTypeSaved->prevalence_threshold , $this->input['prevalence_threshold']);
			$this->assertEquals($testTypeSaved->section_id , $this->input['section_id']);

			$testTypeMeasures = DB::table('testtype_measure')->where('test_type_id', '=', $this->testTypeId)->orderBy('id','desc')->skip(2)->take(2)->get();
			$cnt = 1;
			foreach ($testTypeMeasures as $testTypeMeasure) {
				$this->assertEquals($testTypeMeasure->measure_id, $this->input['measures'][$cnt]);
				$cnt--;
			}
			$testTypeSpecimenTypes = DB::table('testtype_specimentype')->where('test_type_id', '=', $this->testTypeId)->orderBy('id','desc')->skip(2)->take(2)->get();
			$cnt = 1;
			foreach ($testTypeSpecimenTypes as $testTypeSpecimenType) {
				$this->assertEquals($testTypeSpecimenType->specimen_type_id, $this->input['specimentypes'][$cnt]);
				$cnt--;
			}
			
			$testTypeId['testtype'] = $this->testTypeId;
		}
		echo "Test Type created\n";
		$this->removeTestDataId['test_category'] = $testCategoryIds;
		$this->removeTestDataId['measure'] = $measureIds;
		$this->removeTestDataId['specimen_type'] = $specimenTypeIds;
		$testTypeId['dependencies'] = $this->removeTestDataId;
		return $testTypeId;
  	}

  	/**
  	 * Tests the update function in the TestTypeController
     * @depends testStore
	 * @param  int $testTypeId TestType ID from testStore(), testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testTypeId)
	{
		$testTypeId = $testTypeId['testtype'];
		$testCategoryIds = TestCategory::orderBy('id','desc')->take(1)->get()->toArray();
		$this->testCategoryId['update'] = $testCategoryIds[0]['id'];

		$measureIds = Measure::orderBy('id','desc')->take(2)->get()->toArray();
		$this->measureId['update'][0] = $measureIds[0]['id'];
		$this->measureId['update'][1] = $measureIds[1]['id'];

		$specimenTypeIds = SpecimenType::orderBy('id','desc')->take(2)->get()->toArray();
		$this->specimenTypeId['update'][0] = $specimenTypeIds[0]['id'];
		$this->specimenTypeId['update'][1] = $specimenTypeIds[1]['id'];

		$this->inputUpdate['section_id'] = $this->testCategoryId['update'];
		$this->inputUpdate['measures'] = $this->measureId['update'];
		
		$this->inputUpdate['specimentypes'] = $this->specimenTypeId['update'];

		// Update the TestType Types
		$this->runUpdate($this->inputUpdate, $testTypeId);

		$testTypesSaved = TestType::orderBy('id','desc')->take(1)->get();
		foreach ($testTypesSaved as $testTypeSaved) {
			$this->assertEquals($testTypeSaved->name , $this->inputUpdate['name']);
			$this->assertEquals($testTypeSaved->description , $this->inputUpdate['description']);
			$this->assertEquals($testTypeSaved->targetTAT , $this->inputUpdate['targetTAT']);
			$this->assertEquals($testTypeSaved->prevalence_threshold , $this->inputUpdate['prevalence_threshold']);
			$this->assertEquals($testTypeSaved->section_id , $this->inputUpdate['section_id']);
			
			$testTypeMeasures = DB::table('testtype_measure')->where('test_type_id', '=', $testTypeId)->orderBy('id','desc')->take(2)->get();
			$cnt = 1;
			foreach ($testTypeMeasures as $testTypeMeasure) {
				$this->assertEquals($testTypeMeasure->measure_id, $this->inputUpdate['measures'][$cnt]);
				$cnt--;
			}
			$testTypeSpecimenTypes = DB::table('testtype_specimentype')->where('test_type_id', '=', $testTypeId)->orderBy('id','desc')->take(2)->get();
			$cnt = 1;
			foreach ($testTypeSpecimenTypes as $testTypeSpecimenType) {
				$this->assertEquals($testTypeSpecimenType->specimen_type_id, $this->inputUpdate['specimentypes'][$cnt]);
				$cnt--;
			}
		}
		echo "\nTest Type updated\n";
	}
	
	/**
  	 * Tests the update function in the TestTypeController
     * @depends testStore
	 * @param  int $testTypeId TestType ID from testStore()
	 * @return void
     */
	public function testDelete($testTypeId)
	{
		$this->runDelete($testTypeId['testtype']);
		$testTypesSaved = TestType::withTrashed()->orderBy('id','desc')->take(1)->get();
		foreach ($testTypesSaved as $testTypeSaved) {
			$this->assertNotNull($testTypeSaved->deleted_at);
		}
		echo "\nTest Type softDeleted\n";
	    $this->removeTestData($testTypeId);
	    echo "sample TestType removed from the Database\n";
	}
	
  	/**
  	 *Executes the store function in the TestTypeController
  	 * @param  array $input TestType details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
    	$testType = new TestTypeController;
    	$testType->store();
	}

  	/**
  	 * Executes the update function in the TestTypeController
  	 * @param  array $input TestType details, int $id ID of the TestType stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$testType = new TestTypeController;
    	$testType->update($id);
	}

	/**
	 * Executes the delete function in the TestTypeController
	 * @param  int $id IDs of TestTypes stored
	 * @return void
	 */
	public function runDelete($id)
	{
		$testType = new TestTypeController;
    	$testType->delete($id);
	}

	/**
	 * Inject 2 lab sections
	 * @param array $inputTestCategories TestCategory details
	 * @return array $id TestCategory IDs
	 */
	public function injectTestCategories($inputTestCategories)
	{
		$id = array();
		$cnt=0;
		foreach ($inputTestCategories as $inputTestCategory) {
			$id[$cnt] = DB::table('test_category')->insertGetId($inputTestCategory);
			$cnt++;
		}
			return $id;
	}

	/**
	 * Inject 4 measures 
	 * @param array $inputMeasures Measure details
	 * @return array $id Measure IDs
	 */
	public function injectMeasures($inputMeasures)
	{
		$id = array();
		$cnt=0;
		foreach ($inputMeasures as $inputMeasure) {
			$id[$cnt] = DB::table('measure')->insertGetId($inputMeasure);
			$cnt++;
		}
			return $id;
	}

	/**
	 * Inject 4 specimentypes to use and get  their ids
	 * @param array $inputSpecimenTypes SpecimenType details
	 * @return array $id SpecimenType IDs
	 */
	public function injectSpecimenTypes($inputSpecimenTypes)
	{
		$id = array();
		$cnt=0;
		foreach ($inputSpecimenTypes as $inputSpecimenType) {
			$id[$cnt] = DB::table('specimen_type')->insertGetId($inputSpecimenType);
			$cnt++;
		}
			return $id;
	}

	 /**
	  * Force delete all sample TestTypes from the database
      * @depends testStore
	  * @param  array $testTypeID TestType and dependencies IDs
	  * @return void
	  */
	public function removeTestData($testTypeId)
	{			
		DB::table('testtype_measure')->where('test_type_id', '=', $testTypeId['testtype'])->delete();
		DB::table('testtype_specimentype')->where('test_type_id', '=', $testTypeId['testtype'])->delete();
		DB::table('measure')->delete($testTypeId['dependencies']['measure'][0]);
		DB::table('measure')->delete($testTypeId['dependencies']['measure'][1]);
		DB::table('measure')->delete($testTypeId['dependencies']['measure'][2]);
		DB::table('measure')->delete($testTypeId['dependencies']['measure'][3]);
		DB::table('specimen_type')->delete($testTypeId['dependencies']['specimen_type'][0]);
		DB::table('specimen_type')->delete($testTypeId['dependencies']['specimen_type'][1]);
		DB::table('specimen_type')->delete($testTypeId['dependencies']['specimen_type'][2]);
		DB::table('specimen_type')->delete($testTypeId['dependencies']['specimen_type'][3]);
		DB::table('test_type')->delete($testTypeId['testtype']);
		DB::table('test_category')->delete($testTypeId['dependencies']['test_category'][0]);
		DB::table('test_category')->delete($testTypeId['dependencies']['test_category'][1]);
	}
}