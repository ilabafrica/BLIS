<?php
/**
 * Tests the ControlResultsController functions that edit controlresults infomation 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng, Lucy Mbugua , Pius mathii
 */
use App\Models\User;
use App\Models\ControlTest;
use App\Http\Controllers\ControlResultsController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class ControlResultsControllerTest extends TestCase 
{
	
	use WithoutMiddleware;
	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}

	/**
	* Testing ControlResultsController Update function
	*/
	public function testUpdate()
	{
		echo "\n\nCONTROL RESULTS CONTROLLER TEST\n\n";
		Input::replace($this->inputUpdateResults);
		$controlResultsController = new ControlResultsController;
		$controlResultsController->update(1);

		$results = ControlTest::orderBy('id', 'asc')->first()->controlResults;
		foreach ($results as $result) {
			$key = 'm_'.$result->control_measure_id;
			$this->assertEquals($this->inputUpdateResults[$key], $result->results);
		}
	}

	/**
	 * Contains the testing sample data for the ControlResultsController update fuction.
	 *
	 * @return void
	 */
	private function setVariables(){
		//Setting the current user
		$this->be(User::find(4));

		$this->inputUpdateResults = array(
			'm_1' => '3.70',
			'm_2' => '15.50',
			'm_3' => '19.70',
			'm_4' => '28.90',
			'm_5' => '20.80',
			);
	}
}