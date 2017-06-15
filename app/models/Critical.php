<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Critical extends Eloquent
{
	/**
	 * Enabling soft deletes for chemistry/hematology critical values.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'critical';
	/**
	 * Measures relationship
	 */
	public function measure()
	{
	  return $this->belongsTo('Measure', 'parameter');
	}
	/**
	 * Units for critical ages
	 */
	const DAYS = 1;
	const MONTHS = 2;
	const YEARS = 3;
}