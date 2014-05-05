
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
}