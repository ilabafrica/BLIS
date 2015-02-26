<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ControlMeasureRange extends Eloquent 
{
	//Soft deletes
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	/**
	* Declare table name
	*/
	protected $table = 'control_measure_ranges';

	/**
	* Get ranges in printable format
	*
	* @return string
	*/
	public function getRange()
	{
		$upper = $this->upper_range;
		$lower = $this->lower_range;

		return $upper . " - " . $lower;
	}
}