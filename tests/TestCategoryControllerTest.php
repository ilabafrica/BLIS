<?php
/**
 * Tests the TestCategoryController functions that store, edit and delete testCategories 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Http\Controllers\TestCategoryController;
use App\Models\TestCategory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class TestCategoryControllerTest extends TestCase 
{
	use WithoutMiddleware;
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
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->take(1)->get()->toArray();

		$testCategoriesSaved = TestCategory::find($testCategorystored[0]['id']);
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
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->take(1)->get()->toArray();

		$this->call('PUT', '/testcategory/'.$testCategorystored[0]['id'], $this->testCategoryUpdate);

		$testCategorySaved = TestCategory::find($testCategorystored[0]['id']);
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
		$this->call('POST', '/testcategory', $this->testCategoryData);
		$testCategorystored = TestCategory::orderBy('id','desc')->take(1)->get()->toArray();

		$this->call('DELETE', '/testcategory/'.$testCategorystored[0]['id'], $this->testCategoryData);

		$testCategoriesDeleted = TestCategory::withTrashed()->find($testCategorystored[0]['id']);
		$this->assertNotNull($testCategoriesDeleted->deleted_at);
	}
}