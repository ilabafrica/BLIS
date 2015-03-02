<?php
/**
 * Tests the OrganismController functions that store, edit and delete Organisms 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
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
			'name' => 'Enterococcus species',
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
  		Input::replace($this->organismData);
    	$organism = new OrganismController;
    	$organism->store();
		$organismStored = Organism::orderBy('id','desc')->take(1)->get()->toArray();

		$organismSaved = Organism::find($organismStored[0]['id']);

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

		Input::replace($this->organismData);
    	$organism = new OrganismController;
    	$organism->store();
		$organismStored = Organism::orderBy('id','desc')->take(1)->get()->toArray();


    	Input::replace($this->organismDataUpdate);
    	$organism->update($organismStored[0]['id']);

		$organismSavedUpdated = Organism::find($organismStored[0]['id']);
		$this->assertEquals($organismSavedUpdated->name , $this->organismDataUpdate['name']);
		$this->assertEquals($organismSavedUpdated->description , $this->organismDataUpdate['description']);

		//Getting the drugs related to the organism
		/*$organismDrugUpdated = Organism::find($organismStored[0]['id'])->drugs->toArray();
		
		$this->assertEquals(12, $this->organismDataUpdate['drugs'][0]);*/
	}
	
	/**
  	 * Tests the update function in the OrganismController
	 * @param void
	 * @return void
     */
	public function testDelete()
	{
		/*Input::replace($this->organismData);
    	$organism = new OrganismController;
    	$organism->store();
		$organismStored = Organism::orderBy('id','desc')->take(1)->get()->toArray();


		$organism = new OrganismController;
    	$organism->delete($organismStored[0]['id']);
    	
		$organismSaved = Organism::withTrashed()->find($organismStored[0]['id']);
		$this->assertNotNull($organismSaved->deleted_at);*/
	}
}