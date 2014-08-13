<?php

class MeasureRange extends Eloquent
{
	use SoftDeletingTrait;
    	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_ranges';

	public $timestamps = false;

	/**
	 * Measure relationship
	 */
	// public function measure()
	// {
	//   return $this->belongsTo('Measure');
	// }
}