<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class TestControllerTest extends TestCase 
{

    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
	/**
	 * @group testStart
	 * @param  
	 * @return 
	 */    
 	public function testStart()
	{
		echo "\nTEST CONTROLLER TEST\n\n";
		 // start the test
		Input::replace(array('id' => 2)); // 2 here is a Test->id
	    $test = new TestController;
	    $test->start();
		$test = Test::find(2);  // 2 here is a Test->id
		$this->assertEquals($test->test_status_id , Test::STARTED);
  	}
}