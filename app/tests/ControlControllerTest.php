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
		$this->setVariables();
	}
	//TODO
	// /**
	// * Testing saveResults function
	// */
	// public function testSaveResult()
	// {

	// }

	// public function setVariables(){
	// 	$this->inputSaveResults = array(

	// 	);
	// }
}