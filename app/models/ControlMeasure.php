<?php

class ControlMeasure extends Eloquent {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "control_measures";

	public function controlMeasureRanges()
	{
		return $this->hasMany('ControlMeasureRange');
	}
}