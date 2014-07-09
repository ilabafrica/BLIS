<?php

class MeasureControllerTest extends TestCase 
{
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
 	public function testStore() 
  	{
  		
	    $id = array();
  		/*Store a Numeric Measure Type*/
	    Input::replace([
	      'name' => 'UricAcid',
	      'measure_type_id' => '1',
	      'unit' => 'mg/dl',
	      'description' => 'Description',
	      'agemin' =>['1', '2', '3'], 
	      'agemax' => ['4', '5', '6'], 
	      'gender' => ['1', '1', '1'],
	      'rangemin' => ['12', '32', '45'],
	      'rangemax' => ['32', '34', '45'],
	      ]);
      	$measure = new MeasureController;
    	$measure->store();

	    /*Store a Alphanumeric Measure Type*/
	    Input::replace([
	      'name' => 'BloodGrouping',
	      'measure_type_id' => '2',
	      'unit' => 'Unit',
	      'description' => 'Description',
 		  'val' => ['O-','O+','A-','A+','B-','B+','AB-','AB+']
	      ]);
      	$measure = new MeasureController;
    	$measure->store();
    	
		/*Store a Autocomplete Measure Type*/
	    Input::replace([
	      'name' => 'Autocomplete',
	      'measure_type_id' => '3',
	      'unit' => 'Unit',
	      'description' => 'Description',
 		  'val' => ['One','Two','Three','Four']
	      ]);
      	$measure = new MeasureController;
    	$measure->store();

	    /*Store a Freetext Measure Type*/
	    Input::replace([
	      'name' => 'CSFforBiochemistry',
	      'measure_type_id' => '4',
	      'unit' => 'Unit',
	      'description' => 'Description',
	      ]);
      	$measure = new MeasureController;
    	$measure->store();

		$measuresSaved = Measure::orderBy('id','desc')->take(4)->get();
		// Log::info($measuresSaved);
		foreach ($measuresSaved as $measureSaved) {
    		
			if ($measureSaved->measure_type_id == 1) {
				$this->assertEquals($measureSaved->name , 'UricAcid','Expected UricAcid Here');
				// Log::info($measuresSaved->name);
				// var_dump($measuresSaved->name);
				$this->assertEquals($measureSaved->measure_type_id , '1','Expected 1 Here');
				$this->assertEquals($measureSaved->unit , 'mg/dl','Expected mg/dl Here');
				$this->assertEquals($measureSaved->description , 'Description','Expected Description Here');
				$measureRange = array(
					'agemin' =>['1', '2', '3'],
					'agemax' => ['4', '5', '6'],
					'gender' => ['1', '1', '1'],
					'rangemin' => ['12', '32', '45'],
					'rangemax' => ['32', '34', '45']
				);
				foreach ($measureSaved->measureRanges as $range) {
					$cnt = 0;
					$this->assertEquals($range->age_min, $measureRange['agemin'][$cnt]);
					$this->assertEquals($range->age_max, $measureRange['agemax'][$cnt]);
					$this->assertEquals($range->gender, $measureRange['gender'][$cnt]);
					$this->assertEquals($range->range_lower, $measureRange['rangemin'][$cnt]);
					$this->assertEquals($range->range_upper, $measureRange['rangemax'][$cnt]);
					$cnt++;
			    }
	     	}elseif ($measureSaved->measure_type_id == 2) {
				$this->assertEquals($measureSaved->name , 'BloodGrouping');
				$this->assertEquals($measureSaved->measure_type_id , '2');
				$this->assertEquals($measureSaved->description , 'Description');
				$this->assertEquals($measureSaved->measure_range , 'O-/O+/A-/A+/B-/B+/AB-/AB+');
			}elseif ($measureSaved->measure_type_id == 3) {
				$this->assertEquals($measureSaved->name , 'Autocomplete');
				$this->assertEquals($measureSaved->measure_type_id , '3');
				$this->assertEquals($measureSaved->description , 'Description');
				$this->assertEquals($measureSaved->measure_range , 'One/Two/Three/Four');
			}elseif ($measureSaved->measure_type_id == 4) {
				$this->assertEquals($measureSaved->name , 'CSFforBiochemistry');
				$this->assertEquals($measureSaved->measure_type_id , '4');
				$this->assertEquals($measureSaved->unit , 'Unit');
				$this->assertEquals($measureSaved->description , 'Description');	
			}
		}
  	}

  	

	/*
	public function testEdit()
	{
		$measure = new MeasureController($id = 1);
		$this->assertTrue(is_object($measure->edit($id)));    
	}
	*/
	
	/*
	public function testDelete()
	{
		$measure = new MeasureController($id = 1);
		$this->assertTrue(is_object($measure->delete($id)));   
	}
	*/
	
	/*
	public function removeTestData($id)
	{
		//Force delete the measure
		$measure = Measure::find($id);
		$measure->forceDelete();
	}
	*/
}