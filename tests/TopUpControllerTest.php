<?php
/**
 * Tests the TopUpController functions that store, edit and delete topup infomation 
 * @author
 */
use App\Models\TestCategory;
use App\Models\Commodity;
use App\Models\TopupRequest;
use App\Models\User;
use App\Http\Controllers\TopUpController;

class TopUpControllerTest extends TestCase 
{
	
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the TopUpController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(

			'lab_section' => TestCategory::find(1)->id,
			'commodity' => Commodity::find(1)->id,
			'order_quantity' => '1000',
			'remarks' => 'More quantity required',
			
			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'lab_section' => TestCategory::find(1)->id,
			'commodity' => Commodity::find(1)->id,
			'order_quantity' => '1000',
			'remarks' => 'More quantity required',
						
		);
	}
	/**
	 * Tests the store function in the TopUpController
	 * @param  void
	 * @return int $testTopUpId ID of TopUp stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nTOPUP CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the TopUp
		$this->runStore($this->input);

		$topupSaved = TopUpRequest::orderBy('id','desc')->first();
				
		$this->assertEquals($topupSaved->test_category_id, $this->input['lab_section']);
		$this->assertEquals($topupSaved->commodity_id, $this->input['commodity']);
		$this->assertEquals($topupSaved->order_quantity, $this->input['order_quantity']);
		$this->assertEquals($topupSaved->remarks, $this->input['remarks']);
		
  	}
  	/**
  	 * Tests the update function in the TopUpController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$topupSaved = TopUpRequest::orderBy('id','desc')->first();
		// Update the topup
		$this->runUpdate($this->inputUpdate, $topupSaved->id);

		$topupUpdated = TopUpRequest::orderBy('id','desc')->first();


		$this->assertEquals($topupUpdated->test_category_id, $this->inputUpdate['lab_section']);
		$this->assertEquals($topupUpdated->commodity_id, $this->inputUpdate['commodity']);
		$this->assertEquals($topupUpdated->order_quantity, $this->inputUpdate['order_quantity']);
		$this->assertEquals($topupUpdated->remarks, $this->inputUpdate['remarks']);
		
	}
	/**
  	 * Tests the update function in the TopUpController
     * @depends testStore
	 * @param void
	 * @return void
     */
   public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$topup = new TopUpController;
    	$topup->delete(1);
		$topupDeleted = TopUpRequest::withTrashed()->find(1);
		$this->assertNotNull($topupDeleted->deleted_at);
	}
 	/**
  	 *Executes the store function in the TopUpController
  	 * @param  array $input TopUp details
	 * @return void
  	 */
	public function runStore($input)
	{
		$this->withoutMiddleware();
		$this->call('POST', '/topup', $input);
	}
    /**
  	 * Executes the update function in the TopUpController
  	 * @param  array $input TopUp details, int $id ID of the TopUp stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		$this->withoutMiddleware();
		$this->call('PUT', '/topup/'.$id, $input);
	}
}