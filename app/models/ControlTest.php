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

	/**
	* Relationship between control test and its control
	*/
	public function control()
	{
		return $this->belongsTo('Control');
	}
	/**
	* Relationship with lots
	*/
	public function lot()
	{
		return $this->belongsTo('Lot');
	}
}