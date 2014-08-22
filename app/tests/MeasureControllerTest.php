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
		$measureidone = Measure::find(1);
		$this->assertEquals($measureidone->name , $this->inputNumeric['name']);
		$this->assertEquals($measureidone->measure_type_id ,$this->inputNumeric['measure_type_id']);
		$this->assertEquals($measureidone->unit ,$this->inputNumeric['unit']);
		$this->assertEquals($measureidone->description ,$this->inputNumeric['description']);

		$measureidtwo = Measure::find(2);
		$this->assertEquals($measureidtwo->name , $this->inputAlphanumeric['name']);
		$this->assertEquals($measureidtwo->measure_type_id , $this->inputAlphanumeric['measure_type_id']);
		$this->assertEquals($measureidtwo->description , $this->inputAlphanumeric['description']);
		$this->assertEquals($measureidtwo->measure_range , join('/',$this->inputAlphanumeric['val']));
		
		$measureidthree = Measure::find(3);
		$this->assertEquals($measureidthree->name , $this->inputAutocomplete['name']);
		$this->assertEquals($measureidthree->measure_type_id , $this->inputAutocomplete['measure_type_id']);
		$this->assertEquals($measureidthree->description , $this->inputAutocomplete['description']);
		$this->assertEquals($measureidthree->measure_range , join('/',$this->inputAutocomplete['val']));
		
		$measureidfour = Measure::find(4);
		$this->assertEquals($measureidfour->name , $this->inputFreetext['name']);
		$this->assertEquals($measureidfour->measure_type_id , $this->inputFreetext['measure_type_id']);
		$this->assertEquals($measureidfour->description , $this->inputFreetext['description']);

		$measurerangeidone = MeasureRange::find(1);
		$this->assertEquals($measurerangeidone->age_min, $this->inputNumeric['agemin'][0]);
		$this->assertEquals($measurerangeidone->age_max, $this->inputNumeric['agemax'][0]);
		$this->assertEquals($measurerangeidone->gender, $this->inputNumeric['gender'][0]);
		$this->assertEquals($measurerangeidone->range_lower, $this->inputNumeric['rangemin'][0]);
		$this->assertEquals($measurerangeidone->range_upper, $this->inputNumeric['rangemax'][0]);

		$measurerangeidtwo = MeasureRange::find(2);
		$this->assertEquals($measurerangeidtwo->age_min, $this->inputNumeric['agemin'][1]);
		$this->assertEquals($measurerangeidtwo->age_max, $this->inputNumeric['agemax'][1]);
		$this->assertEquals($measurerangeidtwo->gender, $this->inputNumeric['gender'][1]);
		$this->assertEquals($measurerangeidtwo->range_lower, $this->inputNumeric['rangemin'][1]);
		$this->assertEquals($measurerangeidtwo->range_upper, $this->inputNumeric['rangemax'][1]);

		$measurerangeidthree = MeasureRange::find(3);
		$this->assertEquals($measurerangeidthree->age_min, $this->inputNumeric['agemin'][2]);
		$this->assertEquals($measurerangeidthree->age_max, $this->inputNumeric['agemax'][2]);
		$this->assertEquals($measurerangeidthree->gender, $this->inputNumeric['gender'][2]);
		$this->assertEquals($measurerangeidthree->range_lower, $this->inputNumeric['rangemin'][2]);
		$this->assertEquals($measurerangeidthree->range_upper, $this->inputNumeric['rangemax'][2]);
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

		// Update the Measure Types
		$this->runUpdate($this->inputNumericUpdate, 1);
		$this->runUpdate($this->inputAlphanumericUpdate, 2);
		$this->runUpdate($this->inputAutocompleteUpdate, 3);
		$this->runUpdate($this->inputFreetextUpdate, 4);
		
		$measureidone = Measure::find(1);
		$this->assertEquals($measureidone->name , $this->inputNumericUpdate['name']);
		$this->assertEquals($measureidone->measure_type_id ,$this->inputNumericUpdate['measure_type_id']);
		$this->assertEquals($measureidone->unit ,$this->inputNumericUpdate['unit']);
		$this->assertEquals($measureidone->description ,$this->inputNumericUpdate['description']);
		
		$measureidtwo = Measure::find(2);
		$this->assertEquals($measureidtwo->name , $this->inputAlphanumericUpdate['name']);
		$this->assertEquals($measureidtwo->measure_type_id , $this->inputAlphanumericUpdate['measure_type_id']);
		$this->assertEquals($measureidtwo->description , $this->inputAlphanumericUpdate['description']);
		$this->assertEquals($measureidtwo->measure_range , join('/',$this->inputAlphanumericUpdate['val']));
		
		$measureidthree = Measure::find(3);	
		$this->assertEquals($measureidthree->name , $this->inputAutocompleteUpdate['name']);
		$this->assertEquals($measureidthree->measure_type_id , $this->inputAutocompleteUpdate['measure_type_id']);
		$this->assertEquals($measureidthree->description , $this->inputAutocompleteUpdate['description']);
		$this->assertEquals($measureidthree->measure_range , join('/',$this->inputAutocompleteUpdate['val']));
		
		$measureidfour = Measure::find(4);
		$this->assertEquals($measureidfour->name , $this->inputFreetextUpdate['name']);
		$this->assertEquals($measureidfour->measure_type_id , $this->inputFreetextUpdate['measure_type_id']);
		$this->assertEquals($measureidfour->description , $this->inputFreetextUpdate['description']);

		$measurerangeidone = MeasureRange::find(1);
		$this->assertEquals($measurerangeidone->age_min, $this->inputNumericUpdate['agemin'][0]);
		$this->assertEquals($measurerangeidone->age_max, $this->inputNumericUpdate['agemax'][0]);
		$this->assertEquals($measurerangeidone->gender, $this->inputNumericUpdate['gender'][0]);
		$this->assertEquals($measurerangeidone->range_lower, $this->inputNumericUpdate['rangemin'][0]);
		$this->assertEquals($measurerangeidone->range_upper, $this->inputNumericUpdate['rangemax'][0]);

		$measurerangeidtwo = MeasureRange::find(2);
		$this->assertEquals($measurerangeidtwo->age_min, $this->inputNumericUpdate['agemin'][1]);
		$this->assertEquals($measurerangeidtwo->age_max, $this->inputNumericUpdate['agemax'][1]);
		$this->assertEquals($measurerangeidtwo->gender, $this->inputNumericUpdate['gender'][1]);
		$this->assertEquals($measurerangeidtwo->range_lower, $this->inputNumericUpdate['rangemin'][1]);
		$this->assertEquals($measurerangeidtwo->range_upper, $this->inputNumericUpdate['rangemax'][1]);

		$measurerangeidthree = MeasureRange::find(3);
		$this->assertEquals($measurerangeidthree->age_min, $this->inputNumericUpdate['agemin'][2]);
		$this->assertEquals($measurerangeidthree->age_max, $this->inputNumericUpdate['agemax'][2]);
		$this->assertEquals($measurerangeidthree->gender, $this->inputNumericUpdate['gender'][2]);
		$this->assertEquals($measurerangeidthree->range_lower, $this->inputNumericUpdate['rangemin'][2]);
		$this->assertEquals($measurerangeidthree->range_upper, $this->inputNumericUpdate['rangemax'][2]);
		
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
		$this->runStore($this->inputAlphanumeric);
		$this->runStore($this->inputAutocomplete);
		$this->runStore($this->inputFreetext);

		//To Do:: Delete for measureranges
		$measureController = new MeasureController();
		$measureController->delete(1);
		$measureController->delete(2);
		$measureController->delete(3);
		$measureController->delete(4);

		$measureidone = Measure::withTrashed()->find(1);
		$this->assertNotNull($measureidone->deleted_at );

		$measureidtwo = Measure::withTrashed()->find(2);
		$this->assertNotNull($measureidtwo->deleted_at);

		$measureidthree = Measure::withTrashed()->find(3);
		$this->assertNotNull($measureidthree->deleted_at );

		$measureidfour = Measure::withTrashed()->find(4);
		$this->assertNotNull($measureidfour->deleted_at);
	}
	
	
  	/**
  	 *Executes the store funtion in the MeasureController
  	 * @param  array $input Measure details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    	$measure = new MeasureController;
	    	$measure->store();
	}

  	/**
  	 * Executes the update funtion in the MeasureController
  	 * @param  array $input Measure details, int $id ID of the Mesure stored (array for numeric Measure)
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
	    	$measure = new MeasureController;
	    	$measure->update($id);
	}

	public function setVariables(){

    		// Initial sample storage data
		$this->inputNumeric = array(
			'id' => '1',
			'name' => 'UricAcid',
			'measure_type_id' => '1',
			'unit' => 'mg/dl',
			'description' => 'Description',
			'agemin' =>['1', '2', '3'], 
			'agemax' => ['4', '5', '6'], 
			'gender' => ['1', '1', '1'],
			'rangemin' => ['12', '32', '45'],
			'rangemax' => ['32', '34', '45'],
		);

		$this->inputAlphanumeric = array(
			'id' => '2',
			'name' => 'BloodGrouping',
			'measure_type_id' => '2',
			'unit' => 'Unit',
			'description' => 'Description',
			'val' => ['O-','O+','A-','A+','B-','B+','AB-','AB+']
		);

		$this->inputAutocomplete = array(
			'id' => '3',
			'name' => 'Autocomplete',
			'measure_type_id' => '3',
			'unit' => 'Unit',
			'description' => 'Description',
			'val' => ['One','Two','Three','Four']
		);

		$this->inputFreetext = array(
			'id' => '4',
			'name' => 'CSFforBiochemistry',
			'measure_type_id' => '4',
			'unit' => 'Unit',
			'description' => 'Description'
		);

		// Editing sample data
		$this->inputNumericUpdate = array(
			'id' => '1',
			'name' => 'Numeric',
			'measure_type_id' => '1',
			'unit' => 'nUnit',
			'description' => 'nDescription',
			'agemin' =>['11', '21', '31'], 
			'agemax' => ['41', '51', '61'], 
			'gender' => ['11', '11', '11'],
			'rangemin' => ['22', '42', '55'],
			'rangemax' => ['42', '44', '55'],
			'measurerangeid' => ['1','2','3'] //Id's of the measurerange for controller to update
		);

		$this->inputAlphanumericUpdate = array(
			'id' => '2',
			'name' => 'AlphaNumeric',
			'measure_type_id' => '2',
			'unit' => 'aUnit',
			'description' => 'aDescription',
			'val' => ['A','B','C','D','E','F','G','H']
		);

		$this->inputAutocompleteUpdate = array(
			'id' => '3',
			'name' => 'AutoComplete',
			'measure_type_id' => '3',
			'unit' => 'aUnit',
			'description' => 'aDescription',
			'val' => ['aOne','aTwo','aThree','aFour']
		);

		$this->inputFreetextUpdate = array(
			'id' => '4',
			'name' => 'FreeText',
			'measure_type_id' => '4',
			'unit' => 'fUnit',
			'description' => 'fDescription'
		);
    	}
}