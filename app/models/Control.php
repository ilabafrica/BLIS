<?php

class Control extends Eloquent {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "controls";

	/**
	 * ConrolMeasures relationship
	 */
	public function ControlMeasures()
	{
	  return $this->hasMany('ControlMeasure');
	}
}