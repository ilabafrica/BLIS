
<?php

class SpecimenType extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'specimen_types';

	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->belongsToMany('TestType', 'testtype_specimentypes');
	}
}