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
}