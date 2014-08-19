<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Measure extends Eloquent
{
	/**
	 * Enabling soft deletes for Measures.
	 *
	 */

	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measures';

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