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
	 * MeasureRange constants
	 */
	//Numeric Test Result Interpretaion Array Key
	const HIGH = 2;
	const NORMAL = 1;
	const LOW = 0;

	/**
	 * Measure relationship
	 */
	// public function measure()
	// {
	//   return $this->belongsTo('Measure');
	// }
}