<?php
/**
 * Tests the CommodityController functions that store, edit and delete commodity infomation 
 * @author
 */
use App\Models\User;
use App\Models\Commodity;
use App\Http\Controllers\CommodityController;

class CommodityControllerTest extends TestCase 
{
	
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the CommodityController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			
			'name' => 'gloves',
			'description' => 'large size',
			'unit_of_issue' => '1',
			'unit_price' => '250.00',
			'item_code' => '7883',
			'storage_req' => 'dry place',
			'min_level' => '100',
			'max_level' => '5000',
			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'name' => 'gloves',
			'description' => 'large size',
			'unit_of_issue' => '1',
			'unit_price' => '250.00',
			'item_code' => '7883',
			'storage_req' => 'dry place',
			'min_level' => '100',
			'max_level' => '5000',
						
		);
	}
	/**
	 * Tests the store function in the CommodityController
	 * @param  void
	 * @return int $testCommodityId ID of Commodity stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nCOMMODITY CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the Commodity
		$this->runStore($this->input);

		$commoditySaved = Commodity::orderBy('id','desc')->first();
// dd($commoditySaved);
		$this->assertEquals($commoditySaved->name, $this->input['name']);
		$this->assertEquals($commoditySaved->description, $this->input['description']);
		$this->assertEquals($commoditySaved->metric_id, $this->input['unit_of_issue']);
		$this->assertEquals($commoditySaved->unit_price, $this->input['unit_price']);
		$this->assertEquals($commoditySaved->item_code, $this->input['item_code']);
		$this->assertEquals($commoditySaved->storage_req, $this->input['storage_req']);
		$this->assertEquals($commoditySaved->min_level, $this->input['min_level']);
		$this->assertEquals($commoditySaved->max_level, $this->input['max_level']);
		
  	}
  	/**
  	 * Tests the update function in the CommodityController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$commoditySaved = Commodity::orderBy('id','desc')->first();
		// Update the commodity
		$this->runUpdate($this->inputUpdate, $commoditySaved->id);

		$commodityUpdated = Commodity::orderBy('id','desc')->first();


		$this->assertEquals($commodityUpdated->name, $this->inputUpdate['name']);
		$this->assertEquals($commodityUpdated->description, $this->inputUpdate['description']);
		$this->assertEquals($commodityUpdated->metric_id, $this->inputUpdate['unit_of_issue']);
		$this->assertEquals($commodityUpdated->unit_price, $this->inputUpdate['unit_price']);
		$this->assertEquals($commodityUpdated->item_code, $this->inputUpdate['item_code']);
		$this->assertEquals($commodityUpdated->storage_req, $this->inputUpdate['storage_req']);
		$this->assertEquals($commodityUpdated->min_level, $this->inputUpdate['min_level']);
		$this->assertEquals($commodityUpdated->max_level, $this->inputUpdate['max_level']);
		
	}
	/**
  	 * Tests the update function in the CommodityController
     * @depends testStore
	 * @param void
	 * @return void
     */
   public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$commodity = new CommodityController;
    	$commodity->delete(1);
		$commodityDeleted = Commodity::withTrashed()->find(1);
		$this->assertNotNull($commodityDeleted->deleted_at);
	}
 	/**
  	 *Executes the store function in the CommodityController
  	 * @param  array $input Commodity details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    $commodity = new CommodityController;
	    $commodity->store();
	}
    /**
  	 * Executes the update function in the CommodityController
  	 * @param  array $input Commodity details, int $id ID of the Commodity stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$commodity = new CommodityController;
    	$commodity->update($id);
	}
}