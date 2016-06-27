<?php
/**
 * Tests the ReportController configuration settings 
 * @author  (c) @iLabAfrica
 */
use App\Models\Disease;
use App\Models\ReportDisease;
use App\Http\Controllers\ReportController;

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
		$this->withoutMiddleware();
	}

	/**
	 * Tests the surveillance report configuration CRUD
	 *
	 * @return void
	 */    
	// todo: test not dynamic enough... do that, suffers when seeding changes
 	public function testifSurveillanceConfigWorks() 
  	{
		echo "\n\nREPORT CONTROLLER TEST\n\n";
		
  		// add, edit and delete surveillance entry
		$this->call('POST', '/reportconfig/surveillance', $this->inputSurveillance);
		// $this->action('POST', 'ReportController@surveillanceConfig', $this->inputSurveillance);

		$surveillanceModel = ReportDisease::all();
		// todo: make it more intelligible
		//Check if entry was added
		$this->assertEquals($surveillanceModel[2]->test_type_id, $this->inputSurveillance['new_surveillance']['1']['test_type']);
		$this->assertEquals($surveillanceModel[2]->disease_id, $this->inputSurveillance['new_surveillance']['1']['disease']);
		//Check if entry was edited
		$this->assertEquals($surveillanceModel[1]->disease_id, $this->inputSurveillance['surveillance']['2']['disease']);

		//Check if entry was deleted - the only available are three => one deleted, one added, one left as is, and one edited
		$this->assertEquals(count($surveillanceModel), 3);
  	}

  	/**
	 * Tests the diseases CRUD
	 *
	 * @return void
	 */
	// todo: test not dynamic enough... do that, suffers when seeding changes, also failing for some request reasons check it out
 	/*public function testifDiseaseCrudWorks() 
  	{
  		// add, edit and delete disease entry
		$this->call('POST', '/reportconfig/disease', $this->inputDisease);
		// $this->action('POST', 'ReportController@disease', $this->inputDisease);

		$diseaseModel = Disease::all();
		//Check if entry was added
		// todo: pick last entry and compare instead
		$this->assertEquals($diseaseModel[2]->name, $this->inputDisease['newDiseases']['1']['disease']);
		//Check if entry was edited
		$this->assertEquals($diseaseModel[0]->name, $this->inputDisease['diseases']['1']['disease']);

		//Check if entry was deleted - the only available are the three above => one deleted
		$this->assertEquals(count($diseaseModel), 4);
  	}*/

	public function setVariables(){
		//There are three seed entries being used
		//app/database/seeds/TestDataSeeder.php
		$this->inputSurveillance = array(
			//adding a new entry
			'new_surveillance' => [
				'1' => ['test_type' => '6','disease' => '2']//WBC => Typhoid  = Added
			],
			//editing and deleting entries
			//by not puting the other one seed entry here, it should be deleted
			'surveillance' => [
				'1' => ['test_type' => '1','disease' => '1'],//BS => Malaria = as is
				'2' => ['test_type' => '2','disease' => '2']//Stool for C/S => Dysentry to Typhoid = Edited
				//Salmonella Antigen Test => Typhoid = not in the input is deleted
			],
			'fromForm' => 'fromForm'
		);

		//There are three seed entries being used
		$this->inputDisease = array(
			//adding a new entry
			'newDiseases' => [
				'1' => ['disease' => 'New Disease']// Added
			],
			//by not puting the other one seed entry here, it should be deleted
			//if not in use
			'diseases' => [
				'1' => ['disease' => 'Edited Disease'],//BS edited,
				// The rest Dysentry and Typhoid not deleted because they are in use
			],
			'fromForm' => 'fromForm'
		);
    }
}