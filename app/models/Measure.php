
<?php

class Measure extends Eloquent
{
	use SoftDeletingTrait;
    	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measures';

	/**
	 * Enabling soft deletes for patient details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * Measure Range relationship
	 */
	public function measureRanges()
	{
	  return $this->hasMany('MeasureRange');
	}

	/**
	 * Measure Type relationship
	 */
	public function measureType()
	{
	  return $this->belongsTo('MeasureType');
	}

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->belongsToMany('TestType', 'testtype_measures');
	}
}