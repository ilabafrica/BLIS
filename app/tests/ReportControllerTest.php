<?php
/**
 * Tests the ReportController configuration settings 
 * @author  (c) @iLabAfrica
 */
class ReportControllerTest extends TestCase 
{
	/**
	 * Default preparations for tests
	 *
	 * @return void
	 */
	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}
	/**
	 * Tests the surveillance report configuration CRUD
	 *
	 * @return void
	 */    
 	public function testifSurveillanceConfigWorks() 
  	{
		echo "\n\nREPORT CONTROLLER TEST\n\n";
		
  		// add, edit and delete surveillance entry
		Input::replace($this->input);	
		$surveillance = new ReportController;
		$surveillance->surveillanceConfig();

		$surveillanceModel = ReportDisease::all();

		//Check if entry was added
		$this->assertEquals($surveillanceModel[2]->disease->name, $this->input['new-surveillance']['1']['disease']);
		//Check if entry was edited
		$this->assertEquals($surveillanceModel[0]->disease->name, $this->input['surveillance']['1']['disease']);
		$this->assertEquals($surveillanceModel[1]->disease->name, $this->input['surveillance']['2']['disease']);

		//Check if entry was deleted - the only available are the three above => one deleted
		$this->assertEquals(count($surveillanceModel), 3);
  	}

	public function setVariables(){
		//There are three seed entries being used
		//app/database/seeds/TestDataSeeder.php
		$this->input = array(
			//adding a new entry
			'new-surveillance' => [
				'1' => ['test-type' => '4','disease' => 'Some Thing New!']
			],
			//editing and deleting entries
			//by not puting the other one seed entry here, it should be deleted
			'surveillance' => [
				'1' => ['test-type' => '1','disease' => 'Just Changed This!'],
				'2' => ['test-type' => '7','disease' => 'Just Changed This as well!']
			],
			'from-form' => 'from-form'
		);
    }
}