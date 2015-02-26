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
		$upper = $this->upper_range;
		$lower = $this->lower_range;
		$unit = $this->unit;

		return $upper . " - " . $lower ." ". $this->ControlMeasure->unit;
	}
}