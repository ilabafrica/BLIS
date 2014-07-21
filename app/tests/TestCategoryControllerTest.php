<?php
/**
 * Tests the TestCategoryController functions that store, edit and delete testCategories 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestCategoryControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the TestCategoryController.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	// Initial sample storage data
		$this->input = array(
			'name' => 'Parasitlogy',
			'description' => 'Lets see',
		);

		
		// Edition sample data
		$this->inputUpdate = array(
			'name' => 'Parasitology',
			'description' => 'I honestly have no idea',
		);

	
		$this->testTestCategoryId = NULL;
    }
	
	/**
	 * Tests the store function in the TestCategoryController
	 * @param  testing Sample from the constructor
	 * @return int $testTestCategoryId ID of TestCategory stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nTEST CATEGORY CONTROLLER TEST\n\n";
  		 // Store the TestCategory
		$this->runStore($this->input);

		$testCategoriesSaved = TestCategory::orderBy('id','desc')->take(1)->get();
		foreach ($testCategoriesSaved as $testCategorySaved) {
			$this->testTestCategoryId = $testCategorySaved->id;
			$this->assertEquals($testCategorySaved->name , $this->input['name']);
			$this->assertEquals($testCategorySaved->description ,$this->input['description']);
			$testTestCategoryId = $this->testTestCategoryId;
		}
		echo "TestCategory created\n";
		return $testTestCategoryId;
  	}

  	/**
  	 * Tests the update function in the TestCategoryController
     * @depends testStore
	 * @param  int $testTestCategoryId TestCategory ID from testStore(), testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testTestCategoryId)
	{
		// Update the TestCategory
		$this->runUpdate($this->inputUpdate, $testTestCategoryId);

		$testCategoriesSaved = TestCategory::orderBy('id','desc')->take(1)->get();
		foreach ($testCategoriesSaved as $testCategorySaved) {
			$this->testTestCategoryId = $testCategorySaved->id;
			$this->assertEquals($testCategorySaved->name , $this->inputUpdate['name']);
			$this->assertEquals($testCategorySaved->description ,$this->inputUpdate['description']);
		}
		echo "\nTestCategory updated\n";
	}

	
	
	/**
  	 * Tests the update function in the TestCategoryController
     * @depends testStore
	 * @param  int $testTestCategoryId TestCategory IDs from testStore()
	 * @return void
     */
	public function testDelete($testTestCategoryId)
	{
		$this->runDelete($testTestCategoryId);
		$testCategoriesSaved = TestCategory::withTrashed()->orderBy('id','desc')->take(1)->get();
		foreach ($testCategoriesSaved as $testCategorySaved) {
			$this->assertNotNull($testCategorySaved->deleted_at);
		}
		echo "\nTestCategory softDeleted\n";
	    $this->removeTestData($testTestCategoryId);
		echo "sample TestCategory removed from the Database\n";
	}
	
	
  	/**
  	 *Executes the store function in the TestCategoryController
  	 * @param  int $input TestCategory details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
    	$testCategory = new TestCategoryController;
    	$testCategory->store();
	}

  	/**
  	 * Executes the update function in the TestCategoryController
  	 * @param  array $input TestCategory details, int $id ID of the TestCategory stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$testCategory = new TestCategoryController;
    	$testCategory->update($id);
	}

	/**
	 * Executes the delete function in the TestCategoryController
	 * @param  int $id ID of TestCategory stored
	 * @return void
	 */
	public function runDelete($id)
	{
		$testCategory = new TestCategoryController;
    	$testCategory->delete($id);
	}

	 /**
	  * Force delete all sample TestCategory from the database
	  * @param  int $id TestCategory ID
	  * @return void
	  */
	public function removeTestData($id)
	{
		DB::table('test_categories')->delete($id);
	}
}