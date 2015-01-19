<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Measure extends Eloquent
{
	const NUMERIC = 1;
	const ALPHANUMERIC = 2;
	const AUTOCOMPLETE = 3;
	const FREETEXT = 4;
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

	/**
	* Return infection counts (Optionally given the measure_range, age_range, gender, date)
	*
	* @param $testTypeId, $measureRange, $ageRange, $gender, $dateFrom, $dateTo
	*/
	public function getAlphaInfection($testTypeId, $measureRange=null, $gender=null, $ageRange=null, $from=null, $to=null){

		// $tests = Test::where('test_type_id', $testTypeId)->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
		// $count = $tests->count();
		// if($measureRange){
		// 	$count = 0;
		// 	foreach ($tests as $test) {
		// 		foreach ($test->testResults as $testResult) {
		// 			$count += $testResults->where('measure_id', $this->id)->where('result', $measureRange)->count();
		// 		}
		// 	}
		// }
		$count = TestResult::where('test_results.measure_id', $this->id)
				->join('tests', 'tests.id', '=', 'test_results.test_id')
				->join('visits', 'visits.id', '=', 'tests.visit_id')
				->join('patients', 'patients.id', '=', 'visits.patient_id')
				->where('test_type_id', $testTypeId);
				if($measureRange){
					$count = $count->where('result', $measureRange);
				}
				if($ageRange){
					$age = explode('-', $ageRange);

					$now = new DateTime('now');
					$finishDate = $now->sub(new DateInterval('P'.$age[0].'Y'))->format('Y-m-d');
					$startDate = $now->sub(new DateInterval('P'.$age[1].'Y'))->format('Y-m-d');
					$count = $count->whereBetween('dob', [$startDate, $finishDate]);
				}
				if($gender){
					$count = $count->whereIn('patients.gender', $gender);
				}
				if($from && $to){
					$count = $count->whereBetween('tests.time_created', [$from, $to]);
				}
		return $count->count();
	}
	public function getNumericInfection($testTypeId, $result, $rangeLower, $rangeUpper, $gender, $ageRange=null, $from = null, $to = null){
		$count = TestResult::where('measure_id', $this->id);
		
			if($result==MeasureRange::NORMAL){
				$count = $count->where('result', '>=', $rangeLower)
							   ->where('result', '<=', $rangeUpper);
			}
			else if($result==MeasureRange::LOW){
				$count = $count->where('result', '<', $rangeLower);
			}
			else if($result==MeasureRange::HIGH){
				$count = $count->where('result', '>', $rangeUpper);
			}
		if($gender){
			$count = $count->join('tests', 'tests.id', '=', 'test_results.test_id')
				->join('visits', 'visits.id', '=', 'tests.visit_id')
				->join('patients', 'patients.id', '=', 'visits.patient_id')
				->whereIn('gender', $gender);
		}
		if($ageRange){
			$age = explode('-', $ageRange);
			$now = new DateTime('now');
			$finishDate = $now->sub(new DateInterval('P'.$age[0].'Y'))->format('Y-m-d');
			$startDate = $now->sub(new DateInterval('P'.$age[1].'Y'))->format('Y-m-d');
			$count = $count->whereBetween('dob', [$startDate, $finishDate]);
		}
		if($from && $to){
			$count = $count->whereBetween('time_created', [$from, $to]);
		}
		return $count->count();
	}
	/**
	* Check if a certain measure is either numeric or alphanumeric
	*
	*/
	public function isAlphaNumeric(){
		if (in_array($this->measureType->id, [Measure::ALPHANUMERIC]))
			return true;
		else
			return false;
	}

	public function isNumeric(){
		if (in_array($this->measureType->id, [Measure::NUMERIC]))
			return true;
		else
			return false;
	}
}