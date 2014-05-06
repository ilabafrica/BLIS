
<?php

class SpecimenType extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'specimen_type';

	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * TestType relationship
	 */
	public function testType()
	{
		return $this->belongsTo('TestType');
	}

}