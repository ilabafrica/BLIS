<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lot extends Model {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "lots";

	//Soft deletes
	use SoftDeletes;
    protected $dates = ['deleted_at'];

	/**
	* Relationship between lot and instrument
	*/
	public function instrument(){
		return $this->belongsTo('App\Models\Instrument');
	}


	public function controlTests(){
		return $this->hasMany('App\Models\ControlTest');
	}
}