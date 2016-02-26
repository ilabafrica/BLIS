<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ControlMeasureRange extends Model 
{
	//Soft deletes
	use SoftDeletes;
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