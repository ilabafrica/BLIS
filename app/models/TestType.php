<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TestType extends Eloquent
{

	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_types';

	/**
	 * TestCategory relationship
	 */
	public function testCategory()
	{
	  return $this->belongsTo('TestCategory', 'test_category_id');
	}

	/**
	 * SpecimenType relationship
	 */
	public function specimenTypes()
	{
	  return $this->belongsToMany('SpecimenType', 'testtype_specimentypes');
	}

	/**
	 * Measures relationship
	 */
	public function measures()
	{
	  return $this->belongsToMany('Measure', 'testtype_measures');
	}

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('Test');
    }

	/**
	 * Set compatible specimen types
	 *
	 * @return void
	 */
	public function setSpecimenTypes($specimenTypes){

		$specimenTypesAdded = array();
		$testTypeID = 0;	

		if(is_array($specimenTypes)){
			foreach ($specimenTypes as $key => $value) {
				$specimenTypesAdded[] = array(
					'test_type_id' => (int)$this->id,
					'specimen_type_id' => (int)$value
					);
				$testTypeID = (int)$this->id;
			}

		}
		// Delete existing test_type measure mappings
		DB::table('testtype_specimentypes')->where('test_type_id', '=', $testTypeID)->delete();

		// Add the new mapping
		DB::table('testtype_specimentypes')->insert($specimenTypesAdded);
	}

	/**
	 * Set test type measures
	 *
	 * @return void
	 */
	public function setMeasures($measures){

		$measuresAdded = array();
		$testTypeID = 0;	

		if(is_array($measures)){
			foreach ($measures as $key => $value) {
				$measuresAdded[] = array(
					'test_type_id' => (int)$this->id,
					'measure_id' => (int)$value
					);
				$testTypeID = (int)$this->id;
			}
		}
		// Delete existing test_type measure mappings
		DB::table('testtype_measures')->where('test_type_id', '=', $testTypeID)->delete();

		// Add the new mapping
		DB::table('testtype_measures')->insert($measuresAdded);
	}

	/**
	* Given the test name we return the test type ID
	*
	* @param $testname the name of the test
	*/
	public static function getTestTypeIdByTestName($testName)
	{
		try 
		{
			$testTypeId = TestType::where('name', 'like', $testName)->firstOrFail();
			return $testTypeId->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The test type ` $testName ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
	/**
	* Return the rate of positive test results (Optionally given the year, month, date)
	*
	* @param $year, $month, $date
	*/
	public function getPrevalenceCount($year = 0, $month = 0, $date = 0)
	{
		$theDate = "";
		if ($year > 0) {
			$theDate .= $year;
			if ($month > 0) {
				$theDate .= "-".sprintf("%02d", $month);
				if ($date > 0) {
					$theDate .= "-".sprintf("%02d", $date);
				}
			}
		}
		$data =  Test::select(DB::raw(
			'ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'))
				->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
				->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
				->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
				->join('test_results', 'tests.id', '=', 'test_results.test_id')
				->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
				->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
				->where('test_types.id', '=', $this->id)
				->where(function($query) use ($theDate){
					if (strlen($theDate)>0) {
						$query->where('time_created', 'LIKE', $theDate."%");
					}
					})
				->whereIn('test_status_id', array(Test::COMPLETED, Test::VERIFIED))
				->groupBy('test_types.id')
				->get();
		return $data;
	}
	/**
	* Return the prevalence counts for all TestTypes for the given date range
	*
	* @param $from, $to
	*/
	public static function getPrevalenceCounts($from, $to){
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));
		$data =  Test::select(DB::raw('test_types.id as id, test_types.name as test, count(tests.specimen_id) as total, 
					SUM(IF(test_results.result=\'Positive\',1,0)) positive, SUM(IF(test_results.result=\'Negative\',1,0)) negative,
					ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'
					))
					->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
					->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
					->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
					->join('test_results', 'tests.id', '=', 'test_results.test_id')
					->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
					->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
					->whereBetween('time_created', array($from, $toPlusOne))
					->whereIn('test_status_id', array(Test::COMPLETED, Test::VERIFIED))
					->groupBy('test_types.id')
					->get();
		return $data;
	}
	/**
	* Return the counts for a test type given the test_status_id, and date range for ungrouped tests
	*
	* @param $testStatusID, $from, $to
	*/
	public function countPerStatus($testStatusID, $from = null, $to = null)
	{

		$tests = $this->tests->filter(function($test) use ($testStatusID){

				if (in_array($test->test_status_id, $testStatusID)){
					return true;
				}
				return false;
			});

		if($to && $from){
			$tests = $tests->filter(function($test) use($to, $from){
				$timeCreated = strtotime($test->time_created);
				if(strtotime($from) < $timeCreated && strtotime($to) >= $timeCreated)
					return true;
				else return false;
			});
		}

		return $tests->count();

	}
}