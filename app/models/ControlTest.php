<?php

class ControlTest extends Eloquent {

	protected $table = 'control_tests';

	/**
	* Relationship between control measure and its result
	*/
	public function controlResults()
	{
		return $this->hasMany('ControlMeasureResult');
	}
	public function Control()
	{
		return $this->belongsTo('Control');
	}
	public function results()
    {
        return $this->hasMany('ControlMeasureResult');
    }

}