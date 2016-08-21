<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

	/**
	 * Get interpretion of measures, LOW or HIGH
	 * TestType relationship
	 */
	public function getResultInterpretation($result)
	{
		$measure = Measure::find($result['measureid']);

		try {
			$measurerange = MeasureRange::where('measure_id', '=', $result['measureid']);
			if ($measure->isNumeric()) {
			// 	$birthDate = new DateTime($result['birthdate']);
			// 	$now = new DateTime();
			// 	$interval = $birthDate->diff($now);
			// 	$seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
			// 	$age = $seconds/(365*24*60*60);
			// 	// $measurerange = $measurerange->where('age_min', '<=', $age)
			// 	// 	->where('age_max', '>=', $age)
			// 	// 	->where('range_lower', '<=', $result['measurevalue'])
			// 	// 	->where('range_upper', '>=', $result['measurevalue'])
			// 	// 	->whereIn('gender', array($result['gender'], 2));
			// } else{
			// 	$measurerange = $measurerange->where('alphanumeric', '=', $result['measurevalue']);
			// }

				$measurerange = $measurerange->first();
				if($measurerange->range_upper < $result['measurevalue'] 
					|| $measurerange->range_lower > $result['measurevalue']){
					$interpretation = "critical";
				}
			}
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

	/**
	 *  Get measure range with given patient patient details
	 *
	 * @return boolean
	 */
	public static function getRange($patient, $measureId)
	{
		$age = $patient->getAge('Y');
		$measureRange = MeasureRange::where('measure_id', '=', $measureId)
									->where('age_min', '<=',  $age)
									->where('age_max', '>=', $age);
		if(count($measureRange->get()) >= 1){
			if(count($measureRange->get()) == 1){
				$lowerUpper = $measureRange->first();
			}
			else if(count($measureRange->get()) > 1){
				$measureRange = $measureRange->where('gender', '=', $patient->gender);
				if(count($measureRange->get()) == 1){
					$lowerUpper = $measureRange->first();
				}
				else {
					return null;
				}
			}
			return "(".$lowerUpper->range_lower." - ".$lowerUpper->range_upper.")";
		}
		return null;
	}
	/**
	 *  Get test result count for the given measure and parameters
	 *
	 * @return count
	 */
	public function totalTestResults($gender=null, $ageRange=null, $from=null, $to=null, $range=null, $positive=null){
		$testResults = TestResult::where('test_results.measure_id', $this->id)
						 ->join('tests', 'tests.id', '=', 'test_results.test_id')
						 ->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
						 ->join('testtype_measures', 'testtype_measures.test_type_id', '=', 'test_types.id')
						 ->where('testtype_measures.measure_id', $this->id)
						 ->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
			if($to && $from){
				$testResults = $testResults->whereBetween('time_created', [$from, $to]);
			}
			if($ageRange || $gender){
				$testResults = $testResults->join('visits', 'tests.visit_id', '=', 'visits.id')
							   ->join('patients', 'visits.patient_id', '=', 'patients.id');
							   if($gender){
							   		$testResults = $testResults->whereIn('gender', $gender);
							   	}
							   	if($ageRange){
							   		$age = explode('-', $ageRange);
									$ageStart = $age[0];
									$ageEnd = $age[1];
									$now = new DateTime('now');
									$clonedDate = clone $now;
									$finishDate = $clonedDate->sub(new DateInterval('P'.$ageStart.'Y'))->format('Y-m-d');
									$clonedDate = clone $now;
									$startDate = $clonedDate->sub(new DateInterval('P'.$ageEnd.'Y'))->format('Y-m-d');
							   		$testResults = $testResults->whereBetween('dob', [$startDate, $finishDate]);
							   	}
			}
			if($range){
				if ($this->isNumeric())
				{
					$mRange = null;
					if($gender)
						$mRange = $this->measureRanges->first();
					else
						$mRange = $this->measureRanges->first();
					$testResults = $testResults->whereRaw("result REGEXP '^[0-9]+\\.?[0-9]*$'");
					if($range[0] == 'Low')
					{
						$testResults = $testResults->where('result', '<', $mRange->range_lower);
					}
					else if($range[0] == 'Normal')
					{
						$testResults = $testResults->where('result', '>=', $mRange->range_lower)->where('result', '<=', $mRange->range_upper);
					}
					else if($range[0] == 'High')
					{
						$testResults = $testResults->where('result', '>', $mRange->range_upper);
					}
				}
				else
				{
					$testResults = $testResults->whereIn('result', $range);
				}
			}
			if($positive)
			{
				$testResults = $testResults->whereNotIn('result', ['nil', 'nill', 'not seen']);
			}
		return $testResults->count();
	}
	/**
	* Given the measure name we return the measure ID
	*
	* @param $measureName the name of the measure
	*/
	public static function getMeasureIdByName($measureName)
	{
		try 
		{
			$measure = Measure::where('name', 'like', $measureName)->firstOrFail();
			return $measure->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The measure ` $measureName ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}
