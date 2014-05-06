
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
	 * Get compatible specimen types
	 *
	 * @return array
	 */
	public function getSpecimenTypes(){
		return DB::table('testtype_specimentype')
					->join('specimen_type', 'testtype_specimentype.specimentype_id', '=', 'specimen_type.id')
					->select('specimen_type.id', 'specimen_type.name')
					->where('testtype_specimentype.testtype_id', '=', $this->id);
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
					'testtype_id' => (int)$this->id,
					'specimentype_id' => (int)$value
					);
			}

		}
		DB::table('testtype_specimentype')->insert($specimentypesadded);
	}

	/**
	 * Get test type measures
	 *
	 * @return array
	 */
	public function getMeasures(){
		return DB::table('testtype_measure')
					->join('measure', 'testtype_measure.measure_id', '=', 'measure.id')
					->select('measure.id', 'measure.name', 'measure.description', 'measure.unit', 'measure.measure_range')
					->where('testtype_measure.testtype_id', '=', $this->id);
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
					'testtype_id' => (int)$this->id,
					'measure_id' => (int)$value
					);
			}
		}
		DB::table('testtype_measure')->insert($measuresadded);
	}
}