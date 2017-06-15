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
	const MONTH_INTERVAL = 0;
	const YEAR_INTERVAL = 1;
	const DAYS_INTERVAL = 2;

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
		$interpretation = '';
		$testId = $result['testId'];		
		$testType = Test::find($testId)->testType;
		if(empty($result['measurevalue']) || preg_match("/[a-zA-Z]/i", $result['measurevalue']) ){
			return null;
		}
		try {
			
			if ($measure->hasCritical()) {
				$birthDate = new DateTime($result['birthdate']);
				$now = new DateTime();
				$interval = $birthDate->diff($now);
				$seconds = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
				$age = $seconds/(365*24*60*60);
				$age_in_years = $age;	//	Age in years
				$age_in_months = $age*12;	//	Age in months
				$age_in_days = $age*365;	//	Age in days
				$units = NULL;
				$critical = Critical::where('parameter', $measure->id);
				if($age_in_years >= 1)
				{
					$units = Critical::YEARS;
					$critical = $critical->where('age_min', '<=', $age_in_years)->where('age_max', '>=', $age_in_years);
				}
				else if($age_in_months >= 1)
				{
					$units = Critical::MONTHS;
					$critical = $critical->where('age_min', '<=', $age_in_months)->where('age_max', '>=', $age_in_months);
				}
				else if($age_in_days >= 1)
				{
					$units = Critical::DAYS;
					$critical = $critical->where('age_min', '<=', $age_in_days)->where('age_max', '>=', $age_in_days);
				}
				$critical = $critical->where('age_unit', $units);
				$gender = $result['gender'];
				$crit = clone $critical;
				$first_check = $crit->where('gender', $gender)->first();
				if($first_check)
					$critical = $critical->where('gender', $gender);
				else
					$critical = $critical->where('gender', Patient::BOTH);
				$critical = $critical->first();
				// $measurerange = $measurerange->where('age_min', '<=', $age)
				// 	// 	->where('age_max', '>=', $age)
				// 	// 	->where('range_lower', '<=', $result['measurevalue'])
				// 	// 	->where('range_upper', '>=', $result['measurevalue'])
				// 	// 	->whereIn('gender', array($result['gender'], 2));
				// } else{
				// 	$measurerange = $measurerange->where('alphanumeric', '=', $result['measurevalue']);
				// }
				// var_dump($critical->critical_low. ' '.$critical->critical_high.' '.$result['measurevalue']);
				if($result['measurevalue'] < $critical->critical_low || $result['measurevalue'] > $critical->critical_high){
					$interpretation = "critical";
					//	Check if corresponding record for critical value exists in table
					$crit = CritVal::where('test_id', $testId)->where('measure_id', $measure->id)->where('test_type_id',$testType->id)->where('test_category_id', $testType->testCategory->id)->first();
					if(!$crit)
					{
						$crit = new CritVal;
						$crit->test_id = $testId;
						$crit->measure_id = $measure->id;
						$crit->gender = $gender;
						$crit->age = $age;
						$crit->test_type_id = $testType->id;
						$crit->test_category_id = $testType->testCategory->id;
						$crit->save();
					}
				}
				else
				{
					$crit = CritVal::where('test_id', $testId)->where('measure_id', $measure->id)->where('test_type_id',$testType->id)->where('test_category_id', $testType->testCategory->id)->first();
					if($crit)
					{
						$crit->delete();
					}
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
		$months = $patient->getAge('M');
		$years = $patient->getAge('Y');
		$days=$patient->getAge('D');
		if($years==0){
			$age=$months/12;
			$measureRange = MeasureRange::where('measure_id', '=', $measureId)
									->where('age_min', '<=',  $age)
									->where('age_max', '>=', $age);
		}else if($months==0){
			$age=$months/365;
			$measureRange = MeasureRange::where('measure_id', '=', $measureId)
									->where('age_min', '<=',  $age)
									->where('age_max', '>=', $age);
		}
		else{
			$age=$years;
			$measureRange = MeasureRange::where('measure_id', '=', $measureId)
									->where('age_min', '<=',  $age)
									->where('age_max', '>=', $age);
		}
		
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
	/**
	 *  Check to if the Measure has critical values
	 *
	 * @return boolean
	 */
	public function hasCritical()
	{
		$counter = Critical::where('parameter', $this->id)->count();
		if($counter > 0)
			return true;
		else 
			return false;
	}
	/**
	 *  Function to count critical values
	 *
	 * @return boolean
	 */
	public function criticals($tc, $ageRange = NULL, $gender = NULL, $from = NULL, $to = NULL)
	{
		if($ageRange)
		{
			$age = explode('-', $ageRange);
			$ageStart = $age[0];
			$ageEnd = $age[1];
		}
		$counter = CritVal::where('test_category_id', $tc)
							->where('measure_id', $this->id);
							if(!is_null($gender))
							{
								$counter = $counter->where('gender', $gender);
							}
							if($ageRange)
							{
								$counter = $counter->where('age', '>=', $ageStart)
												   ->where('age', '<=', $ageEnd);
							}
							if($from && $to)
							{
								$counter = $counter->whereBetween('created_at', [$from, $to]);
							}
							$counter = $counter->count();
		return $counter;
	}
}