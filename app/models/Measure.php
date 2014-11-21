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

	public function getResultInterpretation($result)
	{
		$measure = Measure::find($result['measureid']);

		try {
			$measurerange = MeasureRange::where('measure_id', '=', $result['measureid']);
			if ($measure->measureType->id == MeasureType::NUMERIC_RANGE) {
				$birthDate = new DateTime($result['birthdate']);
				$now = new DateTime();
				$interval = $birthDate->diff($now);
				$seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
				$age = $seconds/(365*24*60*60);
				$measurerange = $measurerange->where('gender', '=', $result['gender'])
					->where('age_min', '<=', $age)
					->where('age_max', '>=', $age);
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
}