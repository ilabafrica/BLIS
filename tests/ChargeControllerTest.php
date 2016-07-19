<?php
/**
 * Tests the ChargeController functions that store, edit and delete charges 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

use App\Models\Charge;
use App\Models\User;
use App\Http\Controllers\ChargeController;
class ChargeControllerTest extends TestCase 
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
	 * Contains the testing sample data for the ChargeController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->chargeData = array(
			'test_id' => '1',
			'current_amount' => '1000',
		);

		
		// Edition sample data
		$this->chargeUpdate = array(
			'test_id' => '1',
			'current_amount' => '2000',
		);
    }
	
	/**
	 * Tests the store function in the ChargeController
	 * @param  void
	 * @return int $testChargeId ID of Charge stored;used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nCHARGE CONTROLLER TEST\n\n";
  		 // Store the Charge
		$this->withoutMiddleware();
      	$this->be(User::first());
		
		$this->call('POST', '/charge', $this->chargeData);
		
		$chargeStored = Charge::orderBy('id','desc')->first();

		$this->assertEquals( $this->chargeData['test_id'] ,$chargeStored->test_id);
		$this->assertEquals($this->chargeData['current_amount'] ,$chargeStored->current_amount);
  	}

  	/**
  	 * Tests the update function in the ChargeController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		$this->withoutMiddleware();
		$this->call('POST', '/charge', $this->chargeData);
		// Update the Charge
		$chargeStored = Charge::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/charge/1', $this->chargeUpdate);

		$chargeUpdated = Charge::find('1');
		$this->assertEquals($chargeUpdated->test_id , $this->chargeUpdate['test_id']);
		$this->assertEquals($chargeUpdated->current_amount ,$this->chargeUpdate['current_amount']);
	}

	/**
  	 * Tests the update function in the ChargeController
	 * @param  void
	 * @return void
     */
	public function testDestroy()
	{
		
		$this->withoutMiddleware();
		$this->call('POST', '/charge', $this->chargeData);
		$chargeStored = Charge::orderBy('id','desc')->first();
        $charge->delete($chargeStored->id);
		// todo: count and check that the total number has reduced by 1
		$this->assertNotEquals($this->chargeData['current_amount'] ,$chargeStored->current_amount);
	}
}
