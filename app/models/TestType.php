
<?php

class TestType extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_type';

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
	  return $this->belongsToMany('SpecimenType', 'testtype_specimentype');
	}

	/**
	 * Measures relationship
	 */
	public function measures()
	{
	  return $this->belongsToMany('Measure', 'testtype_measure');	
	}

	/**
	 * Set compatible specimen types
	 *
	 * @return void
	 */
	public function setSpecimenTypes($specimentypes){

		$pecimentypesadded = array();

		if(is_array($specimentypes)){
			foreach ($specimentypes as $key => $value) {
				$specimentypesadded[] = array(
					'test_type_id' => (int)$this->id,
					'specimen_type_id' => (int)$value
					);
			}

		}
		DB::table('testtype_specimentype')->insert($specimentypesadded);
	}

	/**
	 * Set test type measures
	 *
	 * @return void
	 */
	public function setMeasures($measures){

		$measuresadded = array();

		if(is_array($measures)){
			foreach ($measures as $key => $value) {
				$measuresadded[] = array(
					'test_type_id' => (int)$this->id,
					'measure_id' => (int)$value
					);
			}
		}
		DB::table('testtype_measure')->insert($measuresadded);
	}
}