<?php
/**
 * Tests the LotController functions that store, edit and delete lot infomation 
 * @author
 */
class TopUpControllerTest extends TestCase 
{
	
	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
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
		$response = $this->action('GET', 'LotController@create');
		$this->assertTrue($response->isOk());
		$this->assertViewHas('instruments');
	}

	/**
	* Testing Lot store function
	*/
	public function testStore()
	{
		$response = $this->action('POST', 'LotController@store', $this->inputStoreLots);
		$this->assertTrue($response->isRedirection());
		$this->assertRedirectedToRoute('lot.index');

		$testLot = lot::orderBy('id', 'desc')->first();
		$this->assertEquals($testLot->number, $this->inputStoreLots['number']);
		$this->assertEquals($testLot->description, $this->inputStoreLots['description']);
		$this->assertEquals($testLot->expiry, $this->inputStoreLots['expiry']);
		$this->assertEquals($testLot->instrument_id, $this->inputStoreLots['instrument']);

		
	}

	/**
	* Testing Lot Update function
	*/
	public function testUpdate()
	{
		$response = $this->action('POST', 'LotController@store', $this->inputUpdateLots);
		$this->assertTrue($response->isRedirection());
		$this->assertRedirectedToRoute('lot.index');

		$testLot = lot::orderBy('id', 'desc')->first();
		$this->assertEquals($testLot->number, $this->inputUpdateLots['number']);
		$this->assertEquals($testLot->description, $this->inputUpdateLots['description']);
		$this->assertEquals($testLot->expiry, $this->inputUpdateLots['expiry']);
		$this->assertEquals($testLot->instrument_id, $this->inputUpdateLots['instrument']);
		
	}

	/**
	* Testing Lot destroy funciton
	*/
	public function testDestroy()
	{
		$this->action('DELETE', 'LotController@destroy', array(1));

		$lot = Lot::find(1);
		$this->assertNull($lot);
	}



	private function setVariables(){
		//Setting the current user
		$this->be(User::find(4));

		$this->inputStoreLots = array(
			'number'=>'2015',
			'description' => 'kenya yao',
			'expiry' => '12-12-2015',
			'instrument' => 1,
			);

		$this->inputUpdateLots = array(
			'number'=>'2015',
			'description' => 'Kenya yetu',
			'expiry' => '12-05-2020',
			'instrument' => 2,
			);
	}
}