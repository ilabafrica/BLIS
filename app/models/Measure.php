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

		switch ($measure->measureType->id) {

			case MeasureType::NUMERIC_RANGE:
				// If the given range is available
				$birthDate = new DateTime($result['birthdate']);
				$now = new DateTime();
				$interval = $birthDate->diff($now);
				$seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
				$age = $seconds/(365*24*60*60);
				try {
					$measurerange = MeasureRange::where('measure_id', '=', $result['measureid'])
						->where('gender', '=', $result['gender'])->where('age_min', '<=', $age)
						->where('age_max', '>=', $age)->get()->toArray();

					if ($result['measurevalue'] > $measurerange[0]['range_upper']) {
						$interpretation = MeasureRange::HIGH;
					}elseif ($result['measurevalue'] < $measurerange[0]['range_lower']) {
						$interpretation = MeasureRange::LOW;
					}else{
						$interpretation = MeasureRange::NORMAL;
					}

				} catch (Exception $e) {
					
					$interpretation = null;
				}
				break;
			
			case MeasureType::ALPHANUMERIC:

				//check range - eplode and pic the one
				$results = explode("/", $measure->measure_range);
				//Searches the array for a given value and returns the corresponding key
				$interpretationKey = array_search($result['measurevalue'], $results);
				$interpretationArray = explode("/", $measure->interpretation);
				$interpretation = $interpretationArray[$interpretationKey];
				break;
		}
		return $interpretation;
	}
}