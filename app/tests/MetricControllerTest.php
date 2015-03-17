<?php
/**
 * Tests the MetricController functions that store, edit and delete metric infomation 
 * @author
 */
class MetricControllerTest extends TestCase 
{
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the MetricController.
	 *
	 * @return void
	 */

	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			
			'name' => '100mgs',
			'description' => 'issued in 100mg sachets',
			
			
		);

		// Edition sample data
		$this->inputUpdate = array(
			
			'name' => '100mgs',
			'description' => 'issued in 100mg sachets',
						
		);
	}
	/**
	 * Tests the store function in the MetricController
	 * @param  void
	 * @return int $testMetricId ID of Metric stored; used in testUpdate() to identify test for update
	 */  
	public function testStore() 
  	{
		echo "\n\nMETRIC CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the metric
		$this->runStore($this->input);

		$metricSaved = Metric::orderBy('id','desc')->take(1)->get()->toArray();
				
		$this->assertEquals($metricSaved[0]['name'], $this->input['name']);
		$this->assertEquals($metricSaved[0]['description'], $this->input['description']);
		
		
  	}
  	/**
  	 * Tests the update function in the MetricController
     * @depends testStore
	 * @param void
	 * @return void
     */
  	public function testUpdate()
	{
		$this->be(User::first());
		$this->runStore($this->input);
		$metricSaved = Metric::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the metric
		$this->runUpdate($this->inputUpdate, $metricSaved[0]['id']);

		$metricUpdated = Metric::orderBy('id','desc')->take(1)->get()->toArray();


		$this->assertEquals($metricUpdated[0]['name'], $this->inputUpdate['name']);
		$this->assertEquals($metricUpdated[0]['description'], $this->inputUpdate['description']);
		
		
	}
	/**
  	 * Tests the update function in the MetricController
     * @depends testStore
	 * @param void
	 * @return void
     */


  

   public function testDelete()
	{
		$this->be(User::first());
		
		$this->runStore($this->input);
		$metric = new MetricController;
    	$metric->delete(1);
		$metricDeleted = Metric::withTrashed()->find(1);
		$this->assertNotNull($metricDeleted->deleted_at);
	}


 	/**
  	 *Executes the store function in the MetricController
  	 * @param  array $input Metric details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    $metric = new MetricController;
	    $metric->store();
	}
    /**
  	 * Executes the update function in the MetricController
  	 * @param  array $input Metric details, int $id ID of the Metric stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$metric = new MetricController;
    	$metric->update($id);
	}
}