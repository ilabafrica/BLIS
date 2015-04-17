<?php


class ControlMeasureResult extends Eloquent {

	protected $table = 'control_results';

	/**
	* Relationship between result and measure
	*
	* @return relationship
	*/
	public function controlMeasure()
	{
		return $this->belongsTo('ControlMeasure', 'control_measure_id');
	}
	public function controlTests()
	{
		return $this->belongsTo('controlTest', 'control_test_id');
	}
	
}