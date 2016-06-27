<?php
/**
 * Tests the OrganismController functions that store, edit and delete Organisms 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Organism;
use App\Http\Controllers\OrganismController;

class OrganismControllerTest extends TestCase 
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
	 * Contains the testing sample data for the OrganismController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
		// Initial sample storage data
		$this->organismData = array(
			'name' => 'Enterococcus spp.',
			'description' => 'Grams known',
			'drugs' =>  ['12']
		);

		// Edition sample data
		$this->organismDataUpdate = array(
			'name' => 'Enterococcux species',
			'description' => 'Gram identifiable',
			'drugs' =>  ['12']
		);
    }
	
	/**
	 * Tests the store function in the OrganismController
	 * @param  testing Sample from the constructor
	 * @return array $organismId IDs of Organisms stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
  		echo "\n\nORGANISM CONTROLLER TEST\n\n";
  		 // Store the Organism Types
		$this->withoutMiddleware();
		$this->call('POST', '/organism', $this->organismData);
		$organismStored = Organism::orderBy('id','desc')->first();

		$organismSaved = Organism::find($organismStored->id);

		$this->assertEquals($organismSaved->name , $this->organismData['name']);
		$this->assertEquals($organismSaved->description , $this->organismData['description']);
		
		//Getting the drugs related to the organism
		/*$organismDrugs = $organismSaved->drugs->toArray();
		$this->assertEquals(12, $this->organismData['drugs'][0]);*/
  	}

  	/**
  	 * Tests the update function in the OrganismController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{

		$this->withoutMiddleware();
		$this->call('POST', '/organism', $this->organismData);
		$organismStored = Organism::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/organism/'.$organismStored->id, $this->organismDataUpdate);

		$organismSavedUpdated = Organism::find($organismStored->id);
		$this->assertEquals($organismSavedUpdated->name , $this->organismDataUpdate['name']);
		$this->assertEquals($organismSavedUpdated->description , $this->organismDataUpdate['description']);

		//Getting the drugs related to the organism
		/*$organismDrugUpdated = Organism::find($organismStored->id)->drugs->toArray();
		
		$this->assertEquals(12, $this->organismDataUpdate['drugs'][0]);*/
	}
	
	/**
  	 * Tests the update function in the OrganismController
	 * @param void
	 * @return void
     */
	// todo: before enabling this test, first enable OrganismController::delete
	/*	
	public function testDelete()
	{
		$this->withoutMiddleware();
		$this->call('POST', '/organism', $this->organismData);
		$organismStored = Organism::orderBy('id','desc')->first();
		$organism = new OrganismController;
    	$organism->delete($organismStored->id);
    	
		$organismSaved = Organism::withTrashed()->find($organismStored->id);
		$this->assertNotNull($organismSaved->deleted_at);
	}*/
}