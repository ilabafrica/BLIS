<?php
/**
 * Tests the PaymentController functions that store, edit and delete payments 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

use App\Models\Payment;
use App\Models\User;
use App\Http\Controllers\PaymentController;
class PaymentControllerTest extends TestCase 
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
	 * Contains the testing sample data for the PaymentController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->paymentData = array(
			'patient_id' => '2',
			'charge_id' => '2',
			'full_amount' => '1000',
			'amount_paid' => '500',
		);

		
		// Edition sample data
		$this->paymentUpdate = array(
			'patient_id' => '2',
			'charge_id' => '2',
			'full_amount' => '2000',
			'amount_paid' => '1500',
		);
    }
	
	/**
	 * Tests the store function in the PaymentController
	 * @param  void
	 * @return int $testPaymentId ID of Payment stored;used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nPAYMENT CONTROLLER TEST\n\n";
  		 // Store the Payment
		$this->withoutMiddleware();
      	$this->be(User::first());
		
		$this->call('POST', '/payment', $this->paymentData);
		
		$paymentStored = Payment::orderBy('id','desc')->first();

		$this->assertEquals( $this->paymentData['patient_id'] ,$paymentStored->patient_id);
		$this->assertEquals( $this->paymentData['charge_id'] ,$paymentStored->charge_id);
		$this->assertEquals( $this->paymentData['full_amount'] ,$paymentStored->full_amount);
		$this->assertEquals($this->paymentData['amount_paid'] ,$paymentStored->amount_paid);
  	}

  	/**
  	 * Tests the update function in the PaymentController
	 * @param  void
	 * @return void
     */
	public function testUpdate()
	{
		$this->withoutMiddleware();
		$this->call('POST', '/payment', $this->paymentData);
		// Update the Payment
		$paymentStored = Payment::orderBy('id','desc')->first();

		$this->withoutMiddleware();
		$this->call('PUT', '/payment/1', $this->paymentUpdate);

		$paymentUpdated = Payment::find('1');
		$this->assertEquals($paymentUpdated->patient_id , $this->paymentUpdate['patient_id']);
		$this->assertEquals($paymentUpdated->charge_id , $this->paymentUpdate['charge_id']);
		$this->assertEquals($paymentUpdated->full_amount , $this->paymentUpdate['full_amount']);
		$this->assertEquals($paymentUpdated->amount_paid ,$this->paymentUpdate['amount_paid']);
	}

	/**
  	 * Tests the update function in the PaymentController
	 * @param  void
	 * @return void
     */
	public function testDestroy()
	{
		$this->withoutMiddleware();
		$this->call('POST', '/payment', $this->paymentData);
		$paymentStored = Payment::orderBy('id','desc')->first();
        $paymentStored->delete($paymentStored->id);
		$this->assertEquals(Payment::all()->count() ,0);
	}
}
