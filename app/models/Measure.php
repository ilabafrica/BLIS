<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Measure extends Eloquent
{
	/**
	 * Enabling soft deletes for Measures.
	 *
	 */

	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measures';

	/**
	 * Measure constants
	 */
	const NUMERIC = 1;
	const ALPHANUMERIC = 2;
	const AUTOCOMPLETE = 3;
	const FREETEXT = 4;

	/**
	 * Measure Range relationship
	 */
	public function measureRanges()
	{
	  return $this->hasMany('MeasureRange');
	}

	/**
	 * Measure Type relationship
	 */
	public function measureType()
	{
	  return $this->belongsTo('MeasureType');
	}

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->belongsToMany('TestType', 'testtype_measures');
	}
	public function getResultInterpretation($result)
	{
		$measure = Measure::find($result['measureid']);

		try {
			$measurerange = MeasureRange::where('measure_id', '=', $result['measureid']);
			if ($measure->isNumeric()) {
				$birthDate = new DateTime($result['birthdate']);
				$now = new DateTime();
				$interval = $birthDate->diff($now);
				$seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
				$age = $seconds/(365*24*60*60);
				$measurerange = $measurerange->where('gender', '=', $result['gender'])
					->where('age_min', '<=', $age)
					->where('age_max', '>=', $age)
					->where('range_lower', '<=', $result['measurevalue'])
					->where('range_upper', '>=', $result['measurevalue']);
			} else{
				$measurerange = $measurerange->where('alphanumeric', '=', $result['measurevalue']);
			}
			$measurerange = $measurerange->get()->toArray();

			$interpretation = $measurerange[0]['interpretation'];

		} catch (Exception $e) {
			$interpretation = null;
		}
		return $interpretation;
	}

	/**
	 *  Check to if the Measure Type is Numeric
	 *
	 * @return boolean
	 */
	public function isNumeric()
	{
		if($this->measureType->id == Measure::NUMERIC){
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
		if($this->measureType->id == Measure::ALPHANUMERIC){
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
		if($this->measureType->id == Measure::AUTOCOMPLETE){
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
		if($this->measureType->id == Measure::FREETEXT){
			return true;
		}
		else
			return false;
	}
}