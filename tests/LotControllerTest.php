<?php
/**
 * Tests the LotController functions that store, edit and delete lot infomation 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng, Lucy Mbugua , Pius mathii
 */
use App\Http\Controllers\LotController;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class LotControllerTest extends TestCase 
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
	 * Contains the testing sample data for the LotController.
	 *
	 * @return void
	 */
	private function setVariables(){
		//Setting the current user
		$this->be(User::find(4));

		$this->input = array(
			'number'=>'2015',
			'description' => 'kenya yao',
			'expiry' => '12-12-2015',
			'instrument' => 1,
			);

		$this->inputUpdate = array(
			'number'=>'2015',
			'description' => 'Kenya yetu',
			'expiry' => '12-05-2020',
			'instrument' => 2,
			);
	}
	/**
	* Testing Lot Index page
	*/
	public function testIndex()
	{
		$response = $this->action('GET', 'LotController@index');
		$this->assertTrue($response->isOk());
		$this->assertViewHas('lots');
	}
	/**
	* Testing Lot create method
	*/
	public function testCreate()
	{
		$response = $this->action('GET', 'LotController@index');
		$this->assertTrue($response->isOk());
		$this->assertViewHas('instruments');
	}
	/**
	* Testing Lot store function
	*/
	public function testStore()
	{
		echo "\n\nLOT CONTROLLER TEST\n\n";

		$response = $this->action('POST', 'LotController@store', $this->input);
		$this->assertTrue($response->isRedirection());

		$testLot = lot::orderBy('id', 'desc')->first();
		$this->assertEquals($testLot->number, $this->input['number']);
		$this->assertEquals($testLot->description, $this->input['description']);
		$this->assertEquals($testLot->expiry, $this->input['expiry']);
		$this->assertEquals($testLot->instrument_id, $this->input['instrument']);
		
	}
	/**
	* Testing Lot Update function
	*/
	public function testUpdate()
	{
		$response = $this->action('POST', 'LotController@store', $this->inputUpdate);
		$this->assertTrue($response->isRedirection());

		$testLot = lot::orderBy('id', 'desc')->first();
		$this->assertEquals($testLot->number, $this->inputUpdate['number']);
		$this->assertEquals($testLot->description, $this->inputUpdate['description']);
		$this->assertEquals($testLot->expiry, $this->inputUpdate['expiry']);
		$this->assertEquals($testLot->instrument_id, $this->inputUpdate['instrument']);
		
	}

	/**
	* Testing Lot destroy funciton
	*/
	public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$lot = new LotController;
		$lot->delete(1);
		$lotDeleted = lot::withTrashed()->find(1);
		$this->assertNotNull($lotDeleted->deleted_at);
	}
	/**
	 *Executes the store function in the LotController
	 * @param  array $input Lot details
	* @return void
	 */
	public function runStore($input)
	{
		$response = $this->action('POST', 'LotController@store', $input);
	}

	 /**
  	 * Executes the update function in the LotController
  	 * @param  array $input Lot details, int $id ID of the Lot stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		$response = $this->action('PUT', 'lotController@update', $input);
	}
}