<?php
/**
 * Tests the PanelController functions that store, edit and delete testCategories 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class PanelControllerTest extends TestCase 
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
	 * Contains the testing sample data for the PanelController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->panelTestData = array(
			'name' => 'PanelX',
			'description' => 'Good Condition',
		);

		
		// Edition sample data
		$this->panelTestDataUpdate = array(
			'name' => 'PanelY',
			'description' => 'Please share ',
		);
    }
	
	/**
	 * Tests the store function in the PanelController
	 * @param  void
	 * @return int $testPanelId ID of Panel stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nTEST PANEL CONTROLLER TEST\n\n";
  		 // Store the Panel
        Input::replace($this->panelTestData);
        $testPanel = new PanelController;
        $testPanel->store();
		$testPanelstored = Panel::orderBy('id','desc')->take(1)->get()->toArray();        
		$testPanelSaved = Panel::find($testPanelstored[0]['id']);
		$this->assertEquals($testPanelSaved->name , $this->panelTestData['name']);
		$this->assertEquals($testPanelSaved->description ,$this->panelTestData['description']);
  	}

  	/**
  	 * Tests the update function in the PanelController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		// Update the Panel
        Input::replace($this->panelTestData);
        $testPanel = new PanelController;
        $testPanel->store();
		$testPanelstored = Panel::orderBy('id','desc')->take(1)->get()->toArray();

        Input::replace($this->panelTestDataUpdate);
        $testPanel->update($testPanelstored[0]['id']);

		$testPanelSaved = Panel::find($testPanelstored[0]['id']);
		$this->assertEquals($testPanelSaved->name , $this->panelTestDataUpdate['name']);
		$this->assertEquals($testPanelSaved->description ,$this->panelTestDataUpdate['description']);
	}

//	/**
//  	 * Tests the update function in the PanelController
//	 * @param  void
//	 * @return void
//     */
//	public function testDelete()
//	{
//        Input::replace($this->panelTestData);
//        $testPanel = new PanelController;
//        $testPanel->store();
//		$testPanelstored = Panel::orderBy('id','desc')->take(1)->get()->toArray();
//
//        $testPanel->delete($testPanelstored[0]['id']);
//
//		$testPanelDeleted = Panel::withTrashed()->find($testPanelstored[0]['id']);
//		$this->assertNotNull($testPanelDeleted->deleted_at);
//	}
}
