<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlTest extends Model {

	protected $table = 'control_tests';

	/**
	* Relationship between control measure and its result
	*/
	public function controlResults()
	{
		return $this->hasMany('App\Models\ControlMeasureResult');
	}

	/**
	* Relationship between control test and its control
	*/
	public function Control()
	{
		return $this->belongsTo('App\Models\Control');
	}
}