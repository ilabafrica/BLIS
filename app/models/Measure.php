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

	public function getResultInterpretation($measureid, $age, $measurevalue, $gender)
	{
		$measure = Measure::find($measureid);

		switch ($measure->measureType->id) {

			case MeasureType::NUMERIC_RANGE:
				// If the given range is available
				try {
					$measurerange = MeasureRange::where('measure_id', '=', $measureid)
						->where('gender', '=', $gender)
						// ->where('age_min', '<=', $age)
						// ->where('age_max', '>=', $age)
						->where('range_lower', '<=', $measurevalue)
						->where('range_upper', '>=', $measurevalue)
						->get()->toArray();

					$interpretation = $measurerange[0]['interpretation'];

				} catch (Exception $e) {
					
					$interpretation = Null;
				}
				break;
			
			case MeasureType::ALPHANUMERIC:
				//check range - eplode and pic the one
				$measure->interpretation;
				break;
		}
		return $interpretation;
	}
}