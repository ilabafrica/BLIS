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
		return $this->belongsTo('ControlMeasure');
	}
}