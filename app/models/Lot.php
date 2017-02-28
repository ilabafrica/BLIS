<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Lot extends Eloquent {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "lots";

	//Soft deletes
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];

	/**
	* Relationship with tests
	*/
	public function tests()
	{
		return $this->hasMany('ControlTest');
	}
}