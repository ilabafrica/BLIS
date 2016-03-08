<?php
/**
 * Tests the IssueController functions that store, edit and delete issue infomation 
 * @author
 */
use App\Http\Controllers\IssueController;
use App\Models\TopupRequest;
use App\Models\User;
use App\Models\Receipt;
class IssueControllerTest extends TestCase 
{
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the IssueController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			
			'batch_no' => Receipt::find(1)->id,
			'topup_request_id' => TopupRequest::find(1)->id,
			'quantity_issued' => '20',
			'receivers_name' => 'Lab2',
			'remarks' => 'first issue',
			
		);

		// Edition sample data
		$this->inputUpdate = array(

			'batch_no' => Receipt::find(1)->id,
			'topup_request_id' => TopupRequest::find(1)->id,
			'quantity_issued' => '20',
			'receivers_name' => 'Lab2',
			'remarks' => 'first issue',
						
		);
	}
	/**
	 * Tests the store function in the IssueController
	 * @param  void
	 * @return int $testSupplierId ID of issue stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nISSUE CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the Issue
		$this->runStore($this->input);

		$issueSaved = Issue::orderBy('id','desc')->take(1)->get()->toArray();
				
		$this->assertEquals($issueSaved[0]['receipt_id'], $this->input['batch_no']);
		$this->assertEquals($issueSaved[0]['topup_request_id'], $this->input['topup_request_id']);
		$this->assertEquals($issueSaved[0]['quantity_issued'], $this->input['quantity_issued']);
		$this->assertEquals($issueSaved[0]['issued_to'], $this->input['receivers_name']);
		$this->assertEquals($issueSaved[0]['remarks'], $this->input['remarks']);
		
  	}
  	/**
  	 * Tests the update function in the IssueController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$issueSaved = Issue::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the issue
		$this->runUpdate($this->inputUpdate, $issueSaved[0]['id']);

		$issueUpdated = Issue::orderBy('id','desc')->take(1)->get()->toArray();


		$this->assertEquals($issueUpdated[0]['receipt_id'], $this->inputUpdate['batch_no']);
		$this->assertEquals($issueUpdated[0]['topup_request_id'], $this->inputUpdate['topup_request_id']);
		$this->assertEquals($issueUpdated[0]['quantity_issued'], $this->inputUpdate['quantity_issued']);
		$this->assertEquals($issueUpdated[0]['issued_to'], $this->inputUpdate['receivers_name']);
		$this->assertEquals($issueUpdated[0]['remarks'], $this->inputUpdate['remarks']);
	}
	/**
  	 * Tests the update function in the IssueController
     * @depends testStore
	 * @param void
	 * @return void
     */
   public function testDelete()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$issue = new IssueController;
    	$issue->delete(1);
		$issueDeleted = Issue::withTrashed()->find(1);
		$this->assertNotNull($issueDeleted->deleted_at);
	}
 	/**
  	 *Executes the store function in the IssueController
  	 * @param  array $input Issue details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    $issue = new IssueController;
	    $issue->store();
	}
    /**
  	 * Executes the update function in the IssueController
  	 * @param  array $input Issue details, int $id ID of the Issue stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$issue = new IssueController;
    	$issue->update($id);
	}
}