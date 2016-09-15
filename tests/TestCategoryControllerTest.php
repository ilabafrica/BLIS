<?php
/**
 * Tests the TestCategoryController functions that store, edit and delete testCategories 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Http\Controllers\TestCategoryController;
use App\Models\TestCategory;

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
        Artisan::call('db:seed');
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
		$this->withoutMiddleware();
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->first();

		$testCategoriesSaved = TestCategory::find($testCategorystored->id);
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
		$this->withoutMiddleware();
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/testcategory/'.$testCategorystored->id, $this->testCategoryUpdate);

		$testCategorySaved = TestCategory::find($testCategorystored->id);
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
		$this->withoutMiddleware();
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->first();

		$this->call('DELETE', '/testcategory/'.$testCategorystored->id.'/delete', $this->testCategoryData);

		$testCategoriesDeleted = TestCategory::withTrashed()->find($testCategorystored->id);
		$this->assertNotNull($testCategoriesDeleted->deleted_at);
	}
}