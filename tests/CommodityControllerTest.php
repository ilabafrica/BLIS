<?php
/**
 * Tests the CommodityController functions that store, edit and delete commodity infomation 
 * @author
 */
use App\Models\User;
use App\Models\Commodity;
use App\Http\Controllers\CommodityController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class CommodityControllerTest extends TestCase 
{
	
	use WithoutMiddleware;
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

		$commoditySaved = Commodity::orderBy('id','desc')->take(1)->get()->toArray();
				
		$this->assertEquals($commoditySaved[0]['name'], $this->input['name']);
		$this->assertEquals($commoditySaved[0]['description'], $this->input['description']);
		$this->assertEquals($commoditySaved[0]['metric_id'], $this->input['unit_of_issue']);
		$this->assertEquals($commoditySaved[0]['unit_price'], $this->input['unit_price']);
		$this->assertEquals($commoditySaved[0]['item_code'], $this->input['item_code']);
		$this->assertEquals($commoditySaved[0]['storage_req'], $this->input['storage_req']);
		$this->assertEquals($commoditySaved[0]['min_level'], $this->input['min_level']);
		$this->assertEquals($commoditySaved[0]['max_level'], $this->input['max_level']);
		
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
		$commoditySaved = Commodity::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the commodity
		$this->runUpdate($this->inputUpdate, $commoditySaved[0]['id']);

		$commodityUpdated = Commodity::orderBy('id','desc')->take(1)->get()->toArray();


		$this->assertEquals($commodityUpdated[0]['name'], $this->inputUpdate['name']);
		$this->assertEquals($commodityUpdated[0]['description'], $this->inputUpdate['description']);
		$this->assertEquals($commodityUpdated[0]['metric_id'], $this->inputUpdate['unit_of_issue']);
		$this->assertEquals($commodityUpdated[0]['unit_price'], $this->inputUpdate['unit_price']);
		$this->assertEquals($commodityUpdated[0]['item_code'], $this->inputUpdate['item_code']);
		$this->assertEquals($commodityUpdated[0]['storage_req'], $this->inputUpdate['storage_req']);
		$this->assertEquals($commodityUpdated[0]['min_level'], $this->inputUpdate['min_level']);
		$this->assertEquals($commodityUpdated[0]['max_level'], $this->inputUpdate['max_level']);
		
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