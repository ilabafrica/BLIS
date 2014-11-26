<?php

class MeasureType extends Eloquent
{
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_types';

	/**
	 *  Check to if the Measure Type is Numeric
	 *
	 * @return boolean
	 */
	public function isNumeric()
	{
		if($this->id == 1){
			return true;
		}
		else 
			return false;
	}

	/**
	 *  Check to if the Measure Type is Alphanumeric
	 *
	 * @return boolean
	 */
	public function isAlphanumeric()
	{
		if($this->id == 2){
			return true;
		}
		else 
			return false;
	}

	/**
	 *  Check to if the Measure Type is Autocomplete
	 *
	 * @return boolean
	 */
	public function isAutocomplete()
	{
		if($this->id == 3){
			return true;
		}
		else 
			return false;
	}

	/**
	 *  Check to if the Measure Type is Free Text
	 *
	 * @return boolean
	 */
	public function isFreeText()
	{
		if($this->id == 4){
			return true;
		}
		else 
			return false;
	}
}