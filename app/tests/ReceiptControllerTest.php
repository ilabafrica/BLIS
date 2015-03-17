<?php
/**
 * Tests the SupplierController functions that store, edit and delete receipt infomation 
 * @author
 */
class ReceiptControllerTest extends TestCase 
{
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the ReceiptController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
						
			'commodity_id' => Commodity::find(1)->id,
			'supplier_id' => Supplier::find(1)->id,
			'quantity' => '200',
			'batch_no' => '4535',
			'expiry_date' => '2015-07-17',
			

			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'commodity_id' => Commodity::find(1)->id,
			'supplier_id' => Supplier::find(1)->id,
			'quantity' => '200',
			'batch_no' => '4535',
			'expiry_date' => '2015-07-17',
						
		);
	}
	/**
	 * Tests the store function in the ReceiptController
	 * @param  void
	 * @return int $testReceiptId ID of receipt stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nRECEIPT CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the receipt
		$this->runStore($this->input);

		$receiptSaved = receipt::orderBy('id','desc')->take(1)->get()->toArray();
				
		$this->assertEquals($receiptSaved[0]['commodity_id'], $this->input['commodity_id']);
		$this->assertEquals($receiptSaved[0]['supplier_id'], $this->input['supplier_id']);
		$this->assertEquals($receiptSaved[0]['quantity'], $this->input['quantity']);
		$this->assertEquals($receiptSaved[0]['batch_no'], $this->input['batch_no']);
		$this->assertEquals($receiptSaved[0]['expiry_date'], $this->input['expiry_date']);
		
  	}
  	/**
  	 * Tests the update function in the ReceiptController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$receiptSaved = receipt::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the receipt
		$this->runUpdate($this->inputUpdate, $receiptSaved[0]['id']);

		$receiptUpdated = receipt::orderBy('id','desc')->take(1)->get()->toArray();


		$this->assertEquals($receiptUpdated[0]['commodity_id'], $this->inputUpdate['commodity_id']);
		$this->assertEquals($receiptUpdated[0]['supplier_id'], $this->inputUpdate['supplier_id']);
		$this->assertEquals($receiptUpdated[0]['quantity'], $this->inputUpdate['quantity']);
		$this->assertEquals($receiptUpdated[0]['batch_no'], $this->inputUpdate['batch_no']);
		$this->assertEquals($receiptUpdated[0]['expiry_date'], $this->inputUpdate['expiry_date']);
		
	}
	/**
  	 * Tests the update function in the ReceiptController
     * @depends testStore
	 * @param void
	 * @return void
     */
   public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$receipt = new ReceiptController;
    	$receipt->delete(1);
		$receiptDeleted = Receipt::withTrashed()->find(1);
		$this->assertNotNull($receiptDeleted->deleted_at);
	}
 	/**
  	 *Executes the store function in the ReceiptController
  	 * @param  array $input receipt details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    $receipt = new ReceiptController;
	    $receipt->store();
	}
    /**
  	 * Executes the update function in the ReceiptController
  	 * @param  array $input receipt details, int $id ID of the receipt stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$receipt = new SupplierController;
    	$receipt->update($id);
	}
}