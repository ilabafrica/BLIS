<?php
/**
 * Tests the DrugController functions that store, edit and delete drugs 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Http\Controllers\DrugController;
class DrugControllerTest extends TestCase 
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
			'name' => 'VANCOMYCIN',
			'description' => 'Staphylococci species',
		);
    }
	
	/**
	 * Tests the store function in the DrugController
	 * @param  void
	 * @return int $testDrugId ID of Drug stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nDRUG CONTROLLER TEST\n\n";
  		 // Store the Drug
        Input::replace($this->drugData);
        $drug = new DrugController;
        $drug->store();
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();

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
        Input::replace($this->drugData);
        $drug = new DrugController;
        $drug->store();
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();

        Input::replace($this->drugUpdate);
        $drug->update($drugStored[0]['id']);

		$drugSaved = Drug::find($drugStored[0]['id']);
		$this->assertEquals($drugSaved->name , $this->drugUpdate['name']);
		$this->assertEquals($drugSaved->description ,$this->drugUpdate['description']);
	}

	/**
  	 * Tests the update function in the DrugController
	 * @param  void
	 * @return void
     */
	public function testDelete()
	{	// to be done later
        /*Input::replace($this->drugData);
        $drug = new DrugController;
        $drug->store();
		$drugStored = Drug::orderBy('id','desc')->take(1)->get()->toArray();

        $drug->delete($drugStored[0]['id']);

		$drugDeleted = Drug::withTrashed()->find($drugStored[0]['id']);
		$this->assertNotNull($drugDeleted->deleted_at);*/
	}
}