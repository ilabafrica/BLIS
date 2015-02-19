<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

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
}