<?php

class MeasureRange extends Eloquent
{
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
	public function measure()
	{
	  return $this->belongsTo('Measures');
	}
}