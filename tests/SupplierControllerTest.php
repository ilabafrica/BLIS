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
			'phone_no' => '0728765432',
			'email' => 'builderone@concretejungle.com',
			'physical_address' => '788347 W3-x2 Down.croncrete',
			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'name' => 'Bob Thebuilder',
			'phone_no' => '0728765432',
			'email' => 'buildandt@concretejungle.com',
			'physical_address' => '788347 W3-x2 Down.croncrete',
						
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

		$supplierSaved = Supplier::orderBy('id','desc')->take(1)->get()->toArray();
				
		$this->assertEquals($supplierSaved[0]['name'], $this->input['name']);
		$this->assertEquals($supplierSaved[0]['phone_no'], $this->input['phone_no']);
		$this->assertEquals($supplierSaved[0]['email'], $this->input['email']);
		$this->assertEquals($supplierSaved[0]['physical_address'], $this->input['physical_address']);
		
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
		$supplierSaved = Supplier::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the supplier
		$this->runUpdate($this->inputUpdate, $supplierSaved[0]['id']);

		$supplierUpdated = Supplier::orderBy('id','desc')->take(1)->get()->toArray();


		$this->assertEquals($supplierUpdated[0]['name'], $this->inputUpdate['name']);
		$this->assertEquals($supplierUpdated[0]['phone_no'], $this->inputUpdate['phone_no']);
		$this->assertEquals($supplierUpdated[0]['email'], $this->inputUpdate['email']);
		$this->assertEquals($supplierUpdated[0]['physical_address'], $this->inputUpdate['physical_address']);
		
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
		Input::replace($input);
	    $supplier = new SupplierController;
	    $supplier->store();
	}
    /**
  	 * Executes the update function in the SupplierController
  	 * @param  array $input Supplier details, int $id ID of the Supplier stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$supplier = new SupplierController;
    	$supplier->update($id);
	}
}