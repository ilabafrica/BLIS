
<?php

class TestType extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_types';

	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * TestCategory relationship
	 */
	public function testCategory()
	{
	  return $this->belongsTo('TestCategory', 'section_id');
	}

	/**
	 * SpecimenType relationship
	 */
	public function specimenTypes()
	{
	  return $this->belongsToMany('SpecimenType', 'testtype_specimentypes');
	}

	/**
	 * Measures relationship
	 */
	public function measures()
	{
	  return $this->belongsToMany('Measure', 'testtype_measures');	
	}

	/**
	 * Set compatible specimen types
	 *
	 * @return void
	 */
	public function setSpecimenTypes($specimenTypes){

		$specimenTypesAdded = array();
		$testTypeID = 0;	

		if(is_array($specimenTypes)){
			foreach ($specimenTypes as $key => $value) {
				$specimenTypesAdded[] = array(
					'test_type_id' => (int)$this->id,
					'specimen_type_id' => (int)$value
					);
				$testTypeID = (int)$this->id;
			}

		}
		// Delete existing test_type measure mappings
		DB::table('testtype_specimentypes')->where('test_type_id', '=', $testTypeID)->delete();

		// Add the new mapping
		DB::table('testtype_specimentypes')->insert($specimenTypesAdded);
	}

	/**
	 * Set test type measures
	 *
	 * @return void
	 */
	public function setMeasures($measures){

		$measuresAdded = array();
		$testTypeID = 0;	

		if(is_array($measures)){
			foreach ($measures as $key => $value) {
				$measuresAdded[] = array(
					'test_type_id' => (int)$this->id,
					'measure_id' => (int)$value
					);
				$testTypeID = (int)$this->id;
			}
		}
		// Delete existing test_type measure mappings
		DB::table('testtype_measures')->where('test_type_id', '=', $testTypeID)->delete();

		// Add the new mapping
		DB::table('testtype_measures')->insert($measuresAdded);
	}
}