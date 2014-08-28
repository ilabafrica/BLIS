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
        $test = new TestController;
        $test->start(2);
		$test = Test::find(2);
		$this->assertEquals($test->test_status_id , 2);
  	}
}