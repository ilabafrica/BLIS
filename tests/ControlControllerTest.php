<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\User;
use App\Models\Control;
use App\Models\ControlTest;
use App\Http\Controllers\ControlController;
class ControlControllerTest extends TestCase {

	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}

	/**
	* Testing Control Index page
	*/
	public function testIndex()
	{
		$controlController = new ControlController;
		$response = $controlController->index();
		$this->assertViewHas('controls');
	}

	/**
	* Testing Control create method
	*/
	public function testCreate()
	{
		$controlController = new ControlController;
		$response = $controlController->create();
		$this->assertViewHas('measureTypes');
		$this->assertViewHas('lots');
	}

	/**
	* Testing Control store function
	*/
	public function testStore()
	{
		Input::replace($this->inputStoreControls);
		$controlController = new ControlController;
		$controlController->store();
		$this->assertTrue($response->isRedirection());
		$this->assertRedirectedToRoute('control.index');

		$testControl = Control::orderBy('id', 'desc')->first();
		$this->assertEquals($testControl->name, $this->inputStoreControls['name']);
		$this->assertEquals($testControl->description, $this->inputStoreControls['description']);
		$this->assertEquals($testControl->lot_id, $this->inputStoreControls['lot']);

		$testControlMeasures = $testControl->controlMeasures;

		foreach ($testControlMeasures as $key => $testControlMeasure) {
			$this->assertEquals($this->inputStoreControls['new-measures'][$key]['name'], $testControlMeasure->name);
			$this->assertEquals($this->inputStoreControls['new-measures'][$key]['unit'], $testControlMeasure->unit);
		}
		//TODO: Test for rangemax and ragnemin. Not working currently due to sqlite rounding of the ranges
	}

	/**
	* Testing Control Update function
	*/
	public function testUpdate()
	{
		Input::replace($this->inputUpdateControls);
		$controlController = new ControlController;
		$controlController->store();

		$this->assertTrue($response->isRedirection());
		$this->assertRedirectedToRoute('control.index');

		$testControl = Control::orderBy('id', 'desc')->first();
		$this->assertEquals($testControl->name, $this->inputUpdateControls['name']);
		$this->assertEquals($testControl->description, $this->inputUpdateControls['description']);
		$this->assertEquals($testControl->lot_id, $this->inputUpdateControls['lot']);

		$testControlMeasures = $testControl->controlMeasures;

		foreach ($testControlMeasures as $key => $testControlMeasure) {
			$this->assertEquals($this->inputUpdateControls['new-measures'][$key]['name'], $testControlMeasure->name);
			$this->assertEquals($this->inputUpdateControls['new-measures'][$key]['unit'], $testControlMeasure->unit);
		}
	}

	/**
	* Testing Control destroy funciton
	*/
	public function testDestroy()
	{
		$controlController = new ControlController;
		$controlController->destroy(1);

		$control = Control::find(1);
		$this->assertNull($control);
	}

	/**
	* Testing Control saveResults function
	*/
	public function testSaveResults()
	{
		Input::replace($this->inputSaveResults);
		$controlController = new ControlController;
		$controlController->saveResults(1);

		$results = ControlTest::orderBy('id', 'desc')->first()->controlResults;

		foreach ($results as $result) {
			$key = 'm_'.$result->control_measure_id;
			$this->assertEquals($this->inputSaveResults[$key], $result->results);
		}
	}


	private function setVariables(){
		//Setting the current user
		$this->be(User::find(4));

		$this->inputStoreControls = array(
			'name'=>'Lava hound',
			'description' => 'Terrible creature',
			'lot' => 1,
			'new-measures' => array(
				array('name' => 'xx', 'unit' => 'mmol', 'measure_type_id' => 1, 'rangemin' => '2.63', 'rangemax' => '7.19'),
				array('name' => 'zz', 'unit' => 'mol', 'measure_type_id' => 1, 'rangemin' => '11.65', 'rangemax' => '15.43'),
				)
			);

		$this->inputUpdateControls = array(
			'name'=>'Minion',
			'description' => 'Spits black fire',
			'lot' => 1,
			'new-measures' => array(
				array('name' => 'DD', 'unit' => 'mmol', 'measure_type_id' => 1, 'rangemin' => '2.63', 'rangemax' => '7.19'),
				array('name' => 'LYTHIUM', 'unit' => 'dol', 'measure_type_id' => 1, 'rangemin' => '15.73', 'rangemax' => '25.01'),
				array('name' => 'STYROPROPENE', 'unit' => 'tol', 'measure_type_id' => 1, 'rangemin' => '17.63', 'rangemax' => '20.12'),
				)
			);

		$this->inputSaveResults = array(
			'm_1' => '2.78',
			'm_2' => '13.56',
			'm_3' => '14.77',
			'm_4' => '25.92',
			'm_5' => '18.87',
			);
	}
}