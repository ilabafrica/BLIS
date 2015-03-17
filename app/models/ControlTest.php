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

}