<?php
/**
 * Tests the TestCategoryController functions that store, edit and delete testCategories 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestCategoryControllerTest extends TestCase 
{
    /**
     * Initial setup function for tests
     *
     * @return void
     */
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        $this->setVariables();
    }

	/**
	 * Contains the testing sample data for the TestCategoryController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->testCategoryData = array(
			'name' => 'Karasitlogy',
			'description' => 'Lets see',
		);

		
		// Edition sample data
		$this->testCategoryUpdate = array(
			'name' => 'Karasitology',
			'description' => 'I honestly have no idea',
		);
    }
	
	/**
	 * Tests the store function in the TestCategoryController
	 * @param  void
	 * @return int $testTestCategoryId ID of TestCategory stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nTEST CATEGORY CONTROLLER TEST\n\n";
  		 // Store the TestCategory
        Input::replace($this->testCategoryData);
        $testCategory = new TestCategoryController;
        $testCategory->store();

		$testCategoriesSaved = TestCategory::find(1);
		$this->assertEquals($testCategoriesSaved->name , $this->testCategoryData['name']);
		$this->assertEquals($testCategoriesSaved->description ,$this->testCategoryData['description']);
  	}

  	/**
  	 * Tests the update function in the TestCategoryController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		// Update the TestCategory
        Input::replace($this->testCategoryData);
        $testCategory = new TestCategoryController;
        $testCategory->store();
        Input::replace($this->testCategoryUpdate);
        $testCategory->update(1);

		$testCategorySaved = TestCategory::find(1);
		$this->assertEquals($testCategorySaved->name , $this->testCategoryUpdate['name']);
		$this->assertEquals($testCategorySaved->description ,$this->testCategoryUpdate['description']);
	}

	/**
  	 * Tests the update function in the TestCategoryController
	 * @param  void
	 * @return void
     */
	public function testDelete()
	{
        Input::replace($this->testCategoryData);
        $testCategory = new TestCategoryController;
        $testCategory->store();

        $testCategory->delete(1);

		$testCategoriesDeleted = TestCategory::withTrashed()->find(1);
		$this->assertNotNull($testCategoriesDeleted->deleted_at);
	}
}