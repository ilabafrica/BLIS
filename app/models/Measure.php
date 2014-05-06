
<?php

class Measure extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure';

	/**
	 * Enabling soft deletes for patient details.
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