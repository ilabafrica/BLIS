<?php

class MeasureControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the MeasureController.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	// Initial sample storage data
		$this->inputNumeric = array(
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
			'name' => 'BloodGrouping',
			'measure_type_id' => '2',
			'unit' => 'Unit',
			'description' => 'Description',
			'val' => ['O-','O+','A-','A+','B-','B+','AB-','AB+']
		);

		$this->inputAutocomplete = array(
			'name' => 'Autocomplete',
			'measure_type_id' => '3',
			'unit' => 'Unit',
			'description' => 'Description',
			'val' => ['One','Two','Three','Four']
		);

		$this->inputFreetext = array(
			'name' => 'CSFforBiochemistry',
			'measure_type_id' => '4',
			'unit' => 'Unit',
			'description' => 'Description'
		);

		// Edition sample data
		$this->inputNumericUpdate = array(
			'name' => 'Numeric',
			'measure_type_id' => '1',
			'unit' => 'nUnit',
			'description' => 'nDescription',
			'agemin' =>['11', '21', '31'], 
			'agemax' => ['41', '51', '61'], 
			'gender' => ['11', '11', '11'],
			'rangemin' => ['22', '42', '55'],
			'rangemax' => ['42', '44', '55'],
		);

		$this->inputAlphanumericUpdate = array(
			'name' => 'AlphaNumeric',
			'measure_type_id' => '2',
			'unit' => 'aUnit',
			'description' => 'aDescription',
			'val' => ['A','B','C','D','E','F','G','H']
		);

		$this->inputAutocompleteUpdate = array(
			'name' => 'AutoComplete',
			'measure_type_id' => '3',
			'unit' => 'aUnit',
			'description' => 'aDescription',
			'val' => ['aOne','aTwo','aThree','aFour']
		);

		$this->inputFreetextUpdate = array(
			'name' => 'FreeText',
			'measure_type_id' => '4',
			'unit' => 'fUnit',
			'description' => 'fDescription'
		);
		$this->testMeasureId = array();
		$this->testMeasureId['numeric'] = array();
		$this->testMeasureId['numeric']['measurerangeid'] = array();
    }
	
	/**
	 * Tests the store funtion in the MeasureController
	 * @param  testing Sample from the constructor
	 * @return Id(s) of the test Mesures stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
  		 // Store the Measure Types
		$this->runStore($this->inputNumeric);
		$this->runStore($this->inputAlphanumeric);
		$this->runStore($this->inputAutocomplete);
		$this->runStore($this->inputFreetext);

		$measuresSaved = Measure::orderBy('id','desc')->take(4)->get();
		foreach ($measuresSaved as $measureSaved) {
			if ($measureSaved->measure_type_id == 1) {
				$this->testMeasureId['numeric']['id'] = $measureSaved->id;
				$this->assertEquals($measureSaved->name , $this->inputNumeric['name']);
				$this->assertEquals($measureSaved->measure_type_id ,$this->inputNumeric['measure_type_id']);
				$this->assertEquals($measureSaved->unit ,$this->inputNumeric['unit']);
				$this->assertEquals($measureSaved->description ,$this->inputNumeric['description']);
				$cnt = 0;
				foreach ($measureSaved->measureRanges as $range) {
					$this->testMeasureId['numeric']['measurerangeid'][$cnt] = $range->id;
					$this->assertEquals($range->age_min, $this->inputNumeric['agemin'][$cnt]);
					$this->assertEquals($range->age_max, $this->inputNumeric['agemax'][$cnt]);
					$this->assertEquals($range->gender, $this->inputNumeric['gender'][$cnt]);
					$this->assertEquals($range->range_lower, $this->inputNumeric['rangemin'][$cnt]);
					$this->assertEquals($range->range_upper, $this->inputNumeric['rangemax'][$cnt]);
					$cnt++;
			    }
	     	}elseif ($measureSaved->measure_type_id == 2) {
				$this->testMeasureId['alphanumeric'] = $measureSaved->id;
				$this->assertEquals($measureSaved->name , $this->inputAlphanumeric['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputAlphanumeric['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputAlphanumeric['description']);
				$this->assertEquals($measureSaved->measure_range , join('/',$this->inputAlphanumeric['val']));
			}elseif ($measureSaved->measure_type_id == 3) {
				$this->testMeasureId['autocomplete'] = $measureSaved->id;
				$this->assertEquals($measureSaved->name , $this->inputAutocomplete['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputAutocomplete['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputAutocomplete['description']);
				$this->assertEquals($measureSaved->measure_range , join('/',$this->inputAutocomplete['val']));
			}elseif ($measureSaved->measure_type_id == 4) {
				$this->testMeasureId['freetext'] = $measureSaved->id;
				$this->assertEquals($measureSaved->name , $this->inputFreetext['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputFreetext['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputFreetext['description']);	
			}
		}
		$testMeasureId = $this->testMeasureId;
		return $testMeasureId;
  	}

  	/**
  	 * Tests the update funtion in the MeasureController
     * @depends testStore
	 * @param  testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testMeasureId)
	{
		// Update the Measure Types
		$this->runUpdate($this->inputNumericUpdate, $testMeasureId['numeric']);
		$this->runUpdate($this->inputAlphanumericUpdate, $testMeasureId['alphanumeric']);
		$this->runUpdate($this->inputAutocompleteUpdate, $testMeasureId['autocomplete']);
		$this->runUpdate($this->inputFreetextUpdate, $testMeasureId['freetext']);

		$measuresSaved = Measure::orderBy('id','desc')->take(4)->get();
		foreach ($measuresSaved as $measureSaved) {
    
			if ($measureSaved->measure_type_id == 1) {
				$this->assertEquals($measureSaved->name , $this->inputNumericUpdate['name']);
				$this->assertEquals($measureSaved->measure_type_id ,$this->inputNumericUpdate['measure_type_id']);
				$this->assertEquals($measureSaved->unit ,$this->inputNumericUpdate['unit']);
				$this->assertEquals($measureSaved->description ,$this->inputNumericUpdate['description']);
				$cnt = 0;
				foreach ($measureSaved->measureRanges as $range) {
					$this->assertEquals($range->age_min, $this->inputNumericUpdate['agemin'][$cnt]);
					$this->assertEquals($range->age_max, $this->inputNumericUpdate['agemax'][$cnt]);
					$this->assertEquals($range->gender, $this->inputNumericUpdate['gender'][$cnt]);
					$this->assertEquals($range->range_lower, $this->inputNumericUpdate['rangemin'][$cnt]);
					$this->assertEquals($range->range_upper, $this->inputNumericUpdate['rangemax'][$cnt]);
					$cnt++;
			    }
	     	}elseif ($measureSaved->measure_type_id == 2) {
				$this->assertEquals($measureSaved->name , $this->inputAlphanumericUpdate['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputAlphanumericUpdate['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputAlphanumericUpdate['description']);
				$this->assertEquals($measureSaved->measure_range , join('/',$this->inputAlphanumericUpdate['val']));
			}elseif ($measureSaved->measure_type_id == 3) {
				$this->assertEquals($measureSaved->name , $this->inputAutocompleteUpdate['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputAutocompleteUpdate['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputAutocompleteUpdate['description']);
				$this->assertEquals($measureSaved->measure_range , join('/',$this->inputAutocompleteUpdate['val']));
			}elseif ($measureSaved->measure_type_id == 4) {
				$this->assertEquals($measureSaved->name , $this->inputFreetextUpdate['name']);
				$this->assertEquals($measureSaved->measure_type_id , $this->inputFreetextUpdate['measure_type_id']);
				$this->assertEquals($measureSaved->description , $this->inputFreetextUpdate['description']);	
			}
		}   
	}

	
	
	/*
	public function testDelete()
	{
		$measure = new MeasureController($id = 1);
		$this->assertTrue(is_object($measure->delete($id)));   
	}
	*/
	
  	/**
  	 *Executes the store funtion in the MeasureController
  	 * @param  array of sample measure details $input
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
  	 * @param  array of sample measure details, Id(s) of the test Mesures stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		/**
		 * Separates the measureID of numeric measures from it's numericRangesID(s) 
		 * Adds the measureRangeIDs in to the test Measure array
		 */
		if ($id['measurerangeid'] != NULL) {
			array_push($input, $id['measurerangeid']);
			// Sorts an index issue of the array index "measurerangeid" being replaced by "0"
			if ($input['0'] != NULL) {
				$input['measurerangeid'] = $input['0'];
			}
			$id = $id['id'];
		}
		Input::replace($input);
    	$measure = new MeasureController;
    	$measure->update($id);
	}

	/*
	public function removeTestData($id)
	{
		//Force delete the measure
		$measure = Measure::find($id);
		$measure->forceDelete();
	}
	*/
}