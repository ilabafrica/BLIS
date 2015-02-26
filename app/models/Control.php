<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Control extends Eloquent {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "controls";

	//Soft deletes
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

	/**
	 * ConrolMeasures relationship
	 */
	public function controlMeasures()
	{
	  return $this->hasMany('ControlMeasure');
	}
}