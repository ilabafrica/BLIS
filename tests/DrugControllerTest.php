<?php
/**
 * Tests the DrugController functions that store, edit and delete drugs 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Models\Drug;
use App\Http\Controllers\DrugController;
class DrugControllerTest extends TestCase 
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
	 * Contains the testing sample data for the DrugController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->drugData = array(
			'name' => 'VANCOMYCIN',
			'description' => 'Lets see',
		);

		
		// Edition sample data
		$this->drugUpdate = array(
			'name' => 'VANCOMYCININ',
			'description' => 'Staphylococci species',
		);
    }
	
	/**
	 * Tests the store function in the DrugController
	 * @param  void
	 * @return int $testDrugId ID of Drug stored;used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nDRUG CONTROLLER TEST\n\n";
  		 // Store the Drug
		$this->call('POST', '/drug', $this->drugData);
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();
var_dump($drugStored);
		$drugSaved = Drug::find($drugStored[0]['id']);
		$this->assertEquals($drugSaved->name , $this->drugData['name']);
		$this->assertEquals($drugSaved->description ,$this->drugData['description']);
  	}

  	/**
  	 * Tests the update function in the DrugController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		// Update the Drug
		$this->call('POST', '/drug', $this->drugData);
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();

		$this->call('PUT', '/drug/1', $this->drugUpdate);

		// $drugUpdated = Drug::find($drugStored[0]['id']);
		$drugUpdated = Drug::find('1');
		$this->assertEquals($drugUpdated->name , $this->drugUpdate['name']);
		$this->assertEquals($drugUpdated->description ,$this->drugUpdate['description']);
	}

	/**
  	 * Tests the update function in the DrugController
	 * @param  void
	 * @return void
     */
	public function testDelete()
	{	// to be done later
		/*$this->call('POST', '/drug', $this->drugData);
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();

        $drug->delete($drugStored[0]['id']);

		$drugDeleted = Drug::withTrashed()->find($drugStored[0]['id']);
		$this->assertNotNull($drugDeleted->deleted_at);*/
	}
}