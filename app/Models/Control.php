<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Control extends Model {

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "controls";

	//Soft deletes
	use SoftDeletes;
    protected $dates = ['deleted_at'];

	/**
	 * ConrolMeasures relationship
	 */
	public function controlMeasures()
	{
	  return $this->hasMany('App\Models\ControlMeasure');
	}

	/**
	* relationship between a control and its results
	*/
	public function controlTests()
	{
		return $this->hasMany('App\Models\ControlTest');
	}

	/**
	* Relationship between control and lots
	*/
	public function lot()
	{
		return $this->belongsTo('App\Models\Lot');
	}
}