<?php
/**
 * Tests the SupplierController functions that store, edit and delete supplier infomation 
 * @author
 */
use App\Models\User;
use App\Models\Supplier;
use App\Http\Controllers\SupplierController;

class SupplierControllerTest extends TestCase 
{
	
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the SupplierController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			
			'name' => 'Bob Tzhebuilder',
			'phone' => '0728765432',
			'email' => 'builderone@concretejungle.com',
			'address' => '788347 W3-x2 Down.croncrete',
			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'name' => 'Bob Thebuilder',
			'phone' => '0728765432',
			'email' => 'buildandt@concretejungle.com',
			'address' => '788347 W3-x2 Down.croncrete',
						
		);
	}
	/**
	 * Tests the store function in the SupplierController
	 * @param  void
	 * @return int $testSupplierId ID of Supplier stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nSUPPLIER CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the Supplier
		$this->runStore($this->input);

		$supplierSaved = Supplier::orderBy('id','desc')->first();
				
		$this->assertEquals($this->input['name'], $supplierSaved->name);
		$this->assertEquals($this->input['phone'], $supplierSaved->phone);
		$this->assertEquals($this->input['email'], $supplierSaved->email);
		$this->assertEquals($this->input['address'], $supplierSaved->address);
		
  	}
  	/**
  	 * Tests the update function in the SupplierController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$supplierSaved = Supplier::orderBy('id','desc')->first();
		// Update the supplier
		$this->runUpdate($this->inputUpdate, $supplierSaved->id);

		$supplierUpdated = Supplier::orderBy('id','desc')->first();


		$this->assertEquals($this->inputUpdate['name'], $supplierUpdated->name);
		$this->assertEquals($this->inputUpdate['phone'], $supplierUpdated->phone);
		$this->assertEquals($this->inputUpdate['email'], $supplierUpdated->email);
		$this->assertEquals($this->inputUpdate['address'], $supplierUpdated->address);
		
	}
	/**
  	 * Tests the update function in the SupplierController
     * @depends testStore
	 * @param void
	 * @return void
     */
   public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$supplier = new SupplierController;
    	$supplier->delete(1);
		$supplierDeleted = Supplier::withTrashed()->find(1);
		$this->assertNotNull($supplierDeleted->deleted_at);
	

	}
 	/**
  	 *Executes the store function in the SupplierController
  	 * @param  array $input Supplier details
	 * @return void
  	 */
	public function runStore($input)
	{
		$this->withoutMiddleware();
		$this->call('POST', '/supplier', $input);
	}
    /**
  	 * Executes the update function in the SupplierController
  	 * @param  array $input Supplier details, int $id ID of the Supplier stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		$this->withoutMiddleware();
		$this->call('PUT', '/supplier/'.$id, $input);
	}
}