<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class ControlControllerTest extends TestCase {

	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		// $this->setVariables();
	}

	/**
	* Testing saveResults function
	*/
	public function testSaveResult()
	{
		//Placeholder
		$this->assertEquals(1,1);
	}

	// public function setVariables(){
	// 	$this->inputSaveResults = array(

	// 	);
	// }
}