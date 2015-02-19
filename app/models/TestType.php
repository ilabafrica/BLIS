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
	 * Instrument relationship
	 */
	public function instruments()
	{
	  return $this->belongsToMany('Instrument', 'instrument_testtypes');
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
	* Get TestTypes that support prevalence counts
	*
	* @return Collection TestTypes
	*/
	public static function supportPrevalenceCounts()
	{

		$testTypes = new Illuminate\Database\Eloquent\Collection();

		// Get ALPHANUMERIC measures whose possible results (or their interpretation) can be
		// reduced to either Positive or Negative
		$measures = DB::table('measures')->select(DB::raw('measures.id, measures.name'))
					->join('measure_ranges', 'measures.id', '=', 'measure_ranges.measure_id')
					->where('measures.measure_type_id', '=', Measure::ALPHANUMERIC)
					->where(function($query){
						$query->where('measure_ranges.alphanumeric', '=', 'Positive')
								->orWhere('measure_ranges.alphanumeric', '=', 'Negative')
								->orWhere('measure_ranges.interpretation', '=', 'Positive')
								->orWhere('measure_ranges.interpretation', '=', 'Negative');
					})->get();

		foreach ($measures as $measure) {
			$measureORM = Measure::find($measure->id);
			$objArray = $measureORM->testTypes()->first();
			if(!empty($objArray)){
				foreach ($measureORM->testTypes()->get() as $tType) {
					if($tType->measures()->count() == 1){
						$testTypes->add($tType);
					}
				}
			}
		}
		 return $testTypes->unique()->sortBy('name');
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
		// TODO: Should be changed to a more flexible format i.e. that supports localization
		$data =  Test::select(DB::raw(
			"ROUND(COUNT(DISTINCT IF((test_results.result='Positive' OR ".
				"(measure_ranges.alphanumeric=test_results.result AND measure_ranges.interpretation = 'Positive')),".
				" tests.id,NULL))*100/COUNT(DISTINCT tests.id), 2 ) AS rate"))
				->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
				->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
				->join('measure_ranges', 'testtype_measures.measure_id', '=', 'measure_ranges.measure_id')
				->join('test_results', function($join){
					$join->on('tests.id', '=', 'test_results.test_id')
						 ->on('testtype_measures.measure_id', '=', 'test_results.measure_id');
					})
				->join('measures', 'testtype_measures.measure_id', '=', 'measures.id')
				->where('test_types.id', '=', $this->id)
				->whereIn('test_status_id', array(Test::COMPLETED, Test::VERIFIED))
				->where('measures.measure_type_id', '=', Measure::ALPHANUMERIC)
				->where(function($query){
					$query->where('measure_ranges.alphanumeric', '=', 'Positive')
							->orWhere('measure_ranges.alphanumeric', '=', 'Negative')
							->orWhere('measure_ranges.interpretation', '=', 'Positive')
							->orWhere('measure_ranges.interpretation', '=', 'Negative');
				})
				->where(function($query) use ($theDate){
					if (strlen($theDate)>0) {
						$query->where('time_created', 'LIKE', $theDate."%");
					}
					})
				->groupBy('test_types.id')
				->get();
		return $data;
	}
	/**
	* Return the prevalence counts for all TestTypes for the given date range
	*
	* @param $from, $to
	*/
	public static function getPrevalenceCounts($from, $to, $testTypeID = 0){
		$toPlusOne = date_add(new DateTime($to), date_interval_create_from_date_string('1 day'));

		// TODO: Should be changed to a more flexible format i.e. that supports localization
		$data =  Test::select(DB::raw("test_types.id as id, test_types.name as test, ".
					"COUNT(DISTINCT tests.specimen_id) as total, ".
					"COUNT(DISTINCT IF((test_results.result='Positive' OR ".
						"(measure_ranges.alphanumeric = test_results.result AND measure_ranges.interpretation = 'Positive')),".
						"tests.specimen_id,NULL)) positive, ".
					"COUNT(DISTINCT IF((test_results.result='Negative' OR ".
						"(measure_ranges.alphanumeric = test_results.result AND measure_ranges.interpretation = 'Negative')),".
						"tests.specimen_id,NULL)) negative, ".
					"ROUND(COUNT(DISTINCT IF((test_results.result = 'Positive' OR ".
						"(measure_ranges.alphanumeric = test_results.result AND measure_ranges.interpretation = 'Positive'))".
						", tests.specimen_id, NULL))*100/COUNT(DISTINCT tests.specimen_id ) , 2 ) AS rate"
					))
				->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
				->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
				->join('measure_ranges', 'testtype_measures.measure_id', '=', 'measure_ranges.measure_id')
				->join('measures', 'testtype_measures.measure_id', '=', 'measures.id')
				->join('test_results', function($join){
					$join->on('tests.id', '=', 'test_results.test_id')
						->on('testtype_measures.measure_id', '=', 'test_results.measure_id');
					})
				->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
				->whereIn('test_status_id', array(Test::COMPLETED, Test::VERIFIED))
				->where(function($query) use ($testTypeID){
					if ($testTypeID != 0) {
						$query->where('tests.test_type_id', $testTypeID);
					}
				})
				->where(function($query){
					$query->where('measure_ranges.alphanumeric', '=', 'Positive')
							->orWhere('measure_ranges.alphanumeric', '=', 'Negative')
							->orWhere('measure_ranges.interpretation', '=', 'Positive')
							->orWhere('measure_ranges.interpretation', '=', 'Negative');
				})
				->whereBetween('time_created', array($from, $toPlusOne))
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

		$tests = Test::where('test_type_id', $this->id)->whereIn('test_status_id', $testStatusID);

		if($to && $from){
			$tests = $tests->whereBetween('time_created', [$from, $to]);
		}

		return $tests->count();

	}
	/**
	* Returns grouped test Counts with optional gender, age range, date range
	*
	* @param $testStatusID, $from, $to
	*/
	public function groupedTestCount($gender=null, $ageRange=null, $from=null, $to=null){
			$tests = Test::where('test_type_id', $this->id)
						 ->whereIn('test_status_id', [Test::PENDING, Test::STARTED, Test::COMPLETED, Test::VERIFIED]);
			if($to && $from){
				$tests = $tests->whereBetween('time_created', [$from, $to]);
			}
			if($ageRange || $gender){
				$tests = $tests->join('visits', 'tests.visit_id', '=', 'visits.id')
							   ->join('patients', 'visits.patient_id', '=', 'patients.id');
							   if($gender){
							   		$tests = $tests->whereIn('gender', $gender);
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
							   		$tests = $tests->whereBetween('dob', [$startDate, $finishDate]);
							   	}
			}

		return $tests->count();
	}
	/**
	* Check if a certain test type has measures that are either numeric or alphanumeric
	*
	*/
	public function hasAlphaNuMeasure(){
		$boolean = TestTypeMeasure::where('test_type_id', $this->id)
						->join('measures', 'testtype_measures.measure_id', '=', 'measures.id')
						->where('measure_type_id', Measure::ALPHANUMERIC);
		return $boolean->count();
	}

	public function hasNumeric(){
		$boolean = TestTypeMeasure::where('test_type_id', $this->id)
						->join('measures', 'testtype_measures.measure_id', '=', 'measures.id')
						->where('measure_type_id', Measure::NUMERIC);
		return $boolean->count();
	}
}