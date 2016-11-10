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

	public function ControlMeasure()
	{
		return $this->belongsTo('ControlMeasure');
	}

	/**
	* Get ranges in printable format
	*
	* @return string
	*/
	public function getRangeUnit()
	{
		$lower = $this->lower_range;
		$upper = $this->upper_range;
		$unit = $this->unit;

		return $lower . " - " . $upper ." ". $this->ControlMeasure->unit;
	}
}