<?php

class ReportConfig extends Eloquent
{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'report_configs';

	public $timestamps = false;

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->hasMany('TestType');
	}

	/**
	 * Disease relationship
	 */
	public function disease()
	{
	  return $this->belongsTo('Disease', 'id');
	}
}