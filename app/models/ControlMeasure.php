<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class ControlMeasure extends Eloquent {

	//Soft deletes
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

	/**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = "control_measures";

	/**
	* Return the ranges for this measure
	*
	* @return relationship
	*/
	public function controlMeasureRanges()
	{
		return $this->hasMany('ControlMeasureRange');
	}
	public function controlmeasure()
	{
		return $this->belongsTo('Control');
	}

	/**
	* Check if this measure is Numeric
	*
	* @return boolean
	*/
	public function isNumeric(){
		if($this->control_measure_type_id == Measure::NUMERIC){
			return true;
		}
		else 
			return false;
	}

	/**
	* Check if this measure is Alphanumeric
	*
	* @return boolean
	*/
	public function isAlphanumeric(){
		if($this->control_measure_type_id == Measure::ALPHANUMERIC){
			return true;
		}
		else 
			return false;
	}
	/**
	 * Control measure result relationship
	 */
    public function results()
    {
        return $this->hasMany('ControlMeasureResult');
    }
}