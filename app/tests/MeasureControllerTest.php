<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class MeasureControllerTest extends TestCase 
{
	/**
	 * Default preparations for tests
	 *
	 * @return void
	 */
	public function setup()
	{
		parent::setUp();
		Artisan::call('migrate');
		Artisan::call('db:seed');
		$this->setVariables();
	}
	/**
	 * Tests the store funtion in the MeasureController
	 *
	 * @return void
	 */    
 	public function testifSaveWorks() 
  	{
		echo "\n\nMEASURE CONTROLLER TEST\n\n";
  		// Store the Measure Types
		$this->runStore($this->inputNumeric);
		$this->runStore($this->inputAlphanumeric);
		$this->runStore($this->inputAutocomplete);
		$this->runStore($this->inputFreetext);
		
		//Check if measure was saved
		$measurestored = Measure::orderBy('id','desc')->take(4)->get()->toArray();
		//Freetext
		$this->assertEquals($measurestored[0]['name'] , $this->inputFreetext[0]['name']);
		$this->assertEquals($measurestored[0]['measure_type_id'] , $this->inputFreetext[0]['measure_type_id']);
		$this->assertEquals($measurestored[0]['description'] , $this->inputFreetext[0]['description']);

		//Autocomplete
		$this->assertEquals($measurestored[1]['name'] , $this->inputAutocomplete[0]['name']);
		$this->assertEquals($measurestored[1]['measure_type_id'] , $this->inputAutocomplete[0]['measure_type_id']);
		$this->assertEquals($measurestored[1]['description'] , $this->inputAutocomplete[0]['description']);

		//Alphanumeric
		$this->assertEquals($measurestored[2]['name'] , $this->inputAlphanumeric[0]['name']);
		$this->assertEquals($measurestored[2]['measure_type_id'] , $this->inputAlphanumeric[0]['measure_type_id']);
		$this->assertEquals($measurestored[2]['description'] , $this->inputAlphanumeric[0]['description']);

		//Numeric
		$this->assertEquals($measurestored[3]['name'] , $this->inputNumeric[0]['name']);
		$this->assertEquals($measurestored[3]['measure_type_id'] ,$this->inputNumeric[0]['measure_type_id']);
		$this->assertEquals($measurestored[3]['unit'] ,$this->inputNumeric[0]['unit']);
		$this->assertEquals($measurestored[3]['description'] ,$this->inputNumeric[0]['description']);
		
		$measurerangestored = MeasureRange::orderBy('id','desc')->take(6)->get()->toArray();

		$this->assertEquals($measurerangestored[5]['age_min'], $this->inputNumeric[0]['agemin'][0]);
		$this->assertEquals($measurerangestored[5]['age_max'], $this->inputNumeric[0]['agemax'][0]);
		$this->assertEquals($measurerangestored[5]['gender'], $this->inputNumeric[0]['gender'][0]);
		$this->assertEquals($measurerangestored[5]['range_lower'], $this->inputNumeric[0]['rangemin'][0]);
		$this->assertEquals($measurerangestored[5]['range_upper'], $this->inputNumeric[0]['rangemax'][0]);

		$this->assertEquals($measurerangestored[4]['age_min'], $this->inputNumeric[0]['agemin'][1]);
		$this->assertEquals($measurerangestored[4]['age_max'], $this->inputNumeric[0]['agemax'][1]);
		$this->assertEquals($measurerangestored[4]['gender'], $this->inputNumeric[0]['gender'][1]);
		$this->assertEquals($measurerangestored[4]['range_lower'], $this->inputNumeric[0]['rangemin'][1]);
		$this->assertEquals($measurerangestored[4]['range_upper'], $this->inputNumeric[0]['rangemax'][1]);
		
		$this->assertEquals($measurerangestored[3]['alphanumeric'], $this->inputAlphanumeric[0]['val'][0]);
		$this->assertEquals($measurerangestored[2]['alphanumeric'], $this->inputAlphanumeric[0]['val'][1]);

		$this->assertEquals($measurerangestored[1]['alphanumeric'], $this->inputAutocomplete[0]['val'][0]);
		$this->assertEquals($measurerangestored[0]['alphanumeric'], $this->inputAutocomplete[0]['val'][1]);
  	}

  	/**
  	 * Tests the update funtion in the MeasureController
	 * 
	 * @return void
     */
	public function testIfUpdateWorks()
	{	
		//Save again because teardown() dropped the db :(
		$this->runStore($this->inputNumeric);
		$this->runStore($this->inputAlphanumeric);
		$this->runStore($this->inputAutocomplete);
		$this->runStore($this->inputFreetext);

		$measurestored = Measure::orderBy('id','desc')->take(4)->get()->toArray();
		$measureUricAcid = Measure::where('name', 'LIKE', '%uric%')->orderBy('id','desc')->first();

		$uricMeasureRanges = array();
		$alphanumericRanges = array();
		$autoCompleteRanges = array();
		foreach ($measureUricAcid->measureRanges as $range) {
			$uricMeasureRanges[] = $range->id;
		}

		foreach (Measure::find($measurestored[2]['id'])->measureRanges as $range) {
			$alphanumericRanges[] = $range->id;
		}

		foreach (Measure::find($measurestored[1]['id'])->measureRanges as $range) {
			$autoCompleteRanges[] = $range->id;
		}


		// Update the Measure Types
		// The second argument is the test type ID
		$this->runUpdate($this->inputNumericUpdate, $measureUricAcid->id, $uricMeasureRanges);
		$this->runUpdate($this->inputAlphanumericUpdate, $measurestored[2]['id'], $alphanumericRanges);
		$this->runUpdate($this->inputAutocompleteUpdate, $measurestored[1]['id'], $autoCompleteRanges);
		$this->runUpdate($this->inputFreetextUpdate, $measurestored[0]['id'], 0);
		
		$measureupdated = Measure::orderBy('id','desc')->take(4)->get()->toArray();
		$measureNewUricAcid = Measure::find($measureUricAcid->id);

		// Check that the measure values for the uric acid measure were updated
		$this->assertEquals($measureNewUricAcid->name , $this->inputNumericUpdate[0]['name']);
		$this->assertEquals($measureNewUricAcid->measure_type_id ,$this->inputNumericUpdate[0]['measure_type_id']);
		$this->assertEquals($measureNewUricAcid->unit ,$this->inputNumericUpdate[0]['unit']);
		$this->assertEquals($measureNewUricAcid->description ,$this->inputNumericUpdate[0]['description']);
		
		$this->assertEquals($measureupdated[2]['name'] , $this->inputAlphanumericUpdate[0]['name']);
		$this->assertEquals($measureupdated[2]['measure_type_id'] , $this->inputAlphanumericUpdate[0]['measure_type_id']);
		$this->assertEquals($measureupdated[2]['description'] , $this->inputAlphanumericUpdate[0]['description']);
		
		$this->assertEquals($measureupdated[1]['name'] , $this->inputAutocompleteUpdate[0]['name']);
		$this->assertEquals($measureupdated[1]['measure_type_id'] , $this->inputAutocompleteUpdate[0]['measure_type_id']);
		$this->assertEquals($measureupdated[1]['description'] , $this->inputAutocompleteUpdate[0]['description']);
		
		$this->assertEquals($measureupdated[0]['name'] , $this->inputFreetextUpdate[0]['name']);
		$this->assertEquals($measureupdated[0]['measure_type_id'] , $this->inputFreetextUpdate[0]['measure_type_id']);
		$this->assertEquals($measureupdated[0]['description'] , $this->inputFreetextUpdate[0]['description']);

		$measurerangeupdated = MeasureRange::orderBy('id','desc')->take(6)->get()->toArray();
		$this->assertEquals($measurerangeupdated[5]['age_min'], $this->inputNumericUpdate[0]['agemin'][0]);
		$this->assertEquals($measurerangeupdated[5]['age_max'], $this->inputNumericUpdate[0]['agemax'][0]);
		$this->assertEquals($measurerangeupdated[5]['gender'], $this->inputNumericUpdate[0]['gender'][0]);
		$this->assertEquals($measurerangeupdated[5]['interval'], $this->inputNumericUpdate[0]['interval'][0]);
		$this->assertEquals($measurerangeupdated[5]['range_lower'], $this->inputNumericUpdate[0]['rangemin'][0]);
		$this->assertEquals($measurerangeupdated[5]['range_upper'], $this->inputNumericUpdate[0]['rangemax'][0]);

		$this->assertEquals($measurerangeupdated[4]['age_min'], $this->inputNumericUpdate[0]['agemin'][1]);
		$this->assertEquals($measurerangeupdated[4]['age_max'], $this->inputNumericUpdate[0]['agemax'][1]);
		$this->assertEquals($measurerangeupdated[4]['interval'], $this->inputNumericUpdate[0]['interval'][1]);
		$this->assertEquals($measurerangeupdated[4]['gender'], $this->inputNumericUpdate[0]['gender'][1]);
		$this->assertEquals($measurerangeupdated[4]['range_lower'], $this->inputNumericUpdate[0]['rangemin'][1]);
		$this->assertEquals($measurerangeupdated[4]['range_upper'], $this->inputNumericUpdate[0]['rangemax'][1]);
		
		$this->assertEquals($measurerangeupdated[3]['alphanumeric'], $this->inputAlphanumericUpdate[0]['val'][0]);
		$this->assertEquals($measurerangeupdated[2]['alphanumeric'], $this->inputAlphanumericUpdate[0]['val'][1]);

		$this->assertEquals($measurerangeupdated[1]['alphanumeric'], $this->inputAutocompleteUpdate[0]['val'][0]);
		$this->assertEquals($measurerangeupdated[0]['alphanumeric'], $this->inputAutocompleteUpdate[0]['val'][1]);
	}
	
	/**
  	 * Tests the update funtion in the MeasureController
	 * 
	 * @return void
     */
	public function testIfDeleteWorks()
	{
		//Save again because teardown() dropped the db :(
		$this->runStore($this->inputNumeric);
		$measurestored = Measure::orderBy('id','desc')->take(1)->get()->toArray();
		$id = $measurestored[0]['id'];

		//To Do:: Delete for measureranges
		$measureController = new MeasureController();
		$measureController->delete($id);

		$measureidone = Measure::withTrashed()->find($id);
		$this->assertNotNull($measureidone->deleted_at);
	}

	/**
  	 *Executes the store funtion in the MeasureController
  	 * @param  array $input Measure details
	 * @return void
  	 */
	public function runStore($input)
	{
	    $measure = new MeasureController;
	    $measure->store($input);
	}

  	/**
  	 * Executes the update funtion in the MeasureController
  	 * @param  array $input Measure details, int $id ID of the Mesure stored (array for numeric Measure)
	 * @return void
  	 */
	public function runUpdate($input, $measureId, $measureRanges)
	{
		$input[$measureId] = $input[0];
		unset($input[0]);
		if ($measureRanges != 0) {
			$input[$measureId]['measurerangeid'] = $measureRanges;
		}
	    
	    $measure = new MeasureController;
	    $measure->update($input);
	}

	public function setVariables(){
    	// Initial sample storage data
		$this->inputNumeric = array(
			array(
				'name' => 'UricAcid',
				'measure_type_id' => '1',
				'unit' => 'mg/dl',
				'interval' => '0',
				'description' => 'Description',
				'agemin' =>['1', '2'], 
				'agemax' => ['4', '5'], 
				'gender' => ['1', '1'],
				'rangemin' => ['12', '32'],
				'rangemax' => ['32', '34'],
				'interpretation' => ['inter1', 'inta1'],
			)
		);

		$this->inputAlphanumeric = array(
			array(
				'name' => 'BloodGrouping',
				'measure_type_id' => '2',
				'unit' => 'Unit',
				'description' => 'Description',
				'val' => ['O-','O+'],
				'interpretation' => ['inter1', 'inta1'],
			)
		);

		$this->inputAutocomplete = array(
			array(
				'name' => 'Autocomplete',
				'measure_type_id' => '3',
				'unit' => 'Unit',
				'description' => 'Description',
				'val' => ['One','Two'],
				'interpretation' => ['inter1', 'inta1'],
				)
		);

		$this->inputFreetext = array(
			array(
				'name' => 'CSFforBiochemistry',
				'measure_type_id' => '4',
				'unit' => 'Unit',
				'description' => 'Description'
			)
		);

		// Editing sample data
		$this->inputNumericUpdate = array(
			array(
				'name' => 'Numeric',
				'measure_type_id' => '1',
				'unit' => 'nUnit',
				'interval'=>"0",
				'description' => 'nDescription',
				'agemin' =>['11', '21'], 
				'agemax' => ['41', '51'], 
				'gender' => ['11', '11'],
				'rangemin' => ['22', '42'],
				'rangemax' => ['42', '44'],
				'interpretation' => ['inter2', 'inta2'],
			)
		);

		$this->inputAlphanumericUpdate = array(
			array(
				'name' => 'AlphaNumeric',
				'measure_type_id' => '2',
				'unit' => 'aUnit',
				'description' => 'aDescription',
				'val' => ['A','B'],
				'interpretation' => ['inter2', 'inta2'],
			)
		);

		$this->inputAutocompleteUpdate = array(
			array(
				'name' => 'AutoComplete',
				'measure_type_id' => '3',
				'unit' => 'aUnit',
				'description' => 'aDescription',
				'val' => ['aOne','aTwo'],
				'interpretation' => ['inter2', 'inta2'],
			)
		);

		$this->inputFreetextUpdate = array(
			array(
				'name' => 'FreeText',
				'measure_type_id' => '4',
				'unit' => 'fUnit',
				'description' => 'fDescription'
			)
		);
    }
}