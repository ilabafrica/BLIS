<?php

class Test extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tests';

	public $timestamps = false;

	/**
	 * Test status constants
	 */
	const NOT_RECEIVED = 1;
	const PENDING = 2;
	const STARTED = 3;
	const COMPLETED = 4;
	const VERIFIED = 5;

	/**
	 * Other constants
	 */
	const POSITIVE = '+';

	/**
	 * Visit relationship
	 */
	public function visit()
	{
		return $this->belongsTo('Visit');
	}

	/**
	 * Test Type relationship
	 */
	public function testType()
	{
		return $this->belongsTo('TestType');
	}

	/**
	 * Specimen relationship
	 */
	public function specimen()
	{
		return $this->belongsTo('Specimen');
	}

	/**
	 * Test Status relationship
	 */
	public function testStatus()
	{
		return $this->belongsTo('TestStatus');
	}

	/**
	 * User (created) relationship
	 */
	public function createdBy()
	{
		return $this->belongsTo('User', 'created_by', 'id');
	}
	
	/**
	 * User (tested) relationship
	 */
	public function testedBy()
	{
		return $this->belongsTo('User', 'tested_by', 'id');
	}

	/**
	 * User (verified) relationship
	 */
	public function verifiedBy()
	{
		return $this->belongsTo('User', 'verified_by', 'id');
	}

	/**
	 * Test Results relationship
	 */
	public function testResults()
	{
		return $this->hasMany('TestResult');
	}

	/**
	 * Culture relationship
	 */
	public function culture()
	{
		return $this->hasMany('Culture');
	}
	/**
	 * Drug susceptibility relationship
	 */
	public function susceptibility()
	{
		return $this->hasMany('Susceptibility');
	}

	/**
	 * Check to see if test is external or internal
	 *
	 * @return boolean
	 */
	public function isExternal()
	{
		if($this->external_id == null){
			return false;
		}
		else 
			return true;
	}

	/**
	 * Helper function: check if the Test status is NOT_RECEIVED
	 *
	 * @return boolean
	 */
	public function isNotReceived()
	{
		if($this->test_status_id == Test::NOT_RECEIVED)
			return true;
		else 
			return false;
	}

	/**
	 * Helper function: check if the Test status is PENDING
	 *
	 * @return boolean
	 */
	public function isPending()
	{
		if($this->test_status_id == Test::PENDING)
			return true;
		else 
			return false;
	}

	/**
	 * Helper function: check if the Test status is STARTED
	 *
	 * @return boolean
	 */
	public function isStarted()
	{
		if($this->test_status_id == Test::STARTED)
			return true;
		else 
			return false;
	}

	/**
	 * Helper function: check if the Test status is COMPLETED
	 *
	 * @return boolean
	 */
	public function isCompleted()
	{
		if($this->test_status_id == Test::COMPLETED)
			return true;
		else 
			return false;
	}

	/**
	 * Helper function: check if the Test status is VERIFIED
	 *
	 * @return boolean
	 */
	public function isVerified()
	{
		if($this->test_status_id == Test::VERIFIED)
			return true;
		else 
			return false;
	}
    
    /**
    * Function to get formatted specimenID's e.g PAR-3333
    *
    * @return string
    */
    public function getSpecimenId()
    {
    	$testCategoryName = $this->testType->testCategory->name;
    	return substr($testCategoryName, 0 , 3).'-'.$this->specimen->id;
    }

	/**
	 * Wait Time: Time difference from test reception to start
	 */
	public function getWaitTime()
	{
		$createTime = new DateTime($this->time_created);
		$startTime = new DateTime($this->time_started);
		$interval = $createTime->diff($startTime);

		$waitTime = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
		return $waitTime;
	}

	/**
	 * Turnaround Time: Time difference from test start to end (in seconds)
	 */
	public function getTurnaroundTime()
	{
		$startTime = new DateTime($this->time_started);
		$endTime = new DateTime($this->time_completed);
		$interval = $startTime->diff($endTime);

		$turnaroundTime = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
		return $turnaroundTime;
	}

	/**
	 * Check if patient has paid or not
	 */
	public function isPaid($test)
	{
		//Not from the external system
		if($test->external_patient_number == null) {
			return true;
		}
		elseif( $this->visit->patient->getAge('Y') >= 6
			&& $externalDump->order_stage == "op" 
			&& $externalDump->receipt_number == "" 
			&& $externalDump->receipt_type == ""  )
			return false;
		else 
			return true;
	}
	/**
	 * Turnaround Time as a formated string (Years Weeks Days Hours Minutes Seconds)
	 */
	public function getFormattedTurnaroundTime()
	{
		$tat = $this->getTurnaroundTime();
		$ftat = "";
		$tat_y = intval($tat/(365*24*60*60));
		$tat_w = intval(($tat-($tat_y*(365*24*60*60)))/(7*24*60*60));
		$tat_d = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60)))/(24*60*60));
		$tat_h = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60)))/(60*60));
		$tat_m = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60))-($tat_h*(60*60)))/(60));
		$tat_s = intval(($tat-($tat_y*(365*24*60*60))-($tat_w*(7*24*60*60))-($tat_d*(24*60*60))-($tat_h*(60*60))-($tat_m*(60))));
		if($tat_y > 0) $ftat = $tat_y." ".Lang::choice('messages.year',$tat_y)." ";
		if($tat_w > 0) $ftat .= $tat_w." ".Lang::choice('messages.week',$tat_w)." ";
		if($tat_d > 0) $ftat .= $tat_d." ".Lang::choice('messages.day',$tat_d)." ";
		if($tat_h > 0) $ftat .= $tat_h." ".Lang::choice('messages.hour',$tat_h)." ";
		if($tat_m > 0) $ftat .= $tat_m." ".Lang::choice('messages.minute',$tat_m)." ";
		if($tat_s > 0) $ftat .= $tat_s." ".Lang::choice('messages.second',$tat_s);

		return $ftat;
	}

	/**
	 * Get results by page
	 *
	 * @param int $page
	 * @param int $limit
	 * @return StdClass
	 */
	public function getByPage($page = 1, $limit = 10)
	{
			$results = StdClass;
			$results->page = $page;
			$results->limit = $limit;
			$results->totalItems = 0;
			$results->items = array();
			
			$users = $this->model->skip($limit * ($page - 1))->take($limit)->get();
			
			$results->totalItems = $this->model->count();
			$results->items = $users->all();
			
			return $results;
	}

	/**
	 * Get tests infection data for infection report
	 * Shows counts for complete tests by measure, result, gender and age ranges
	 *
	 * @param string $startTime
	 * @param string $endTime
	 * @return Array[][]
	 */
	public static function getInfectionData($startTime, $endTime, $testCategory=0){

		$lowAgeBound = 5;
		$midAgeBound = 14;

		$testCategoryWhereClause = "";
		if($testCategory!=0) $testCategoryWhereClause = " AND tt.test_category_id = $testCategory";

		$data = DB::select(
			"SELECT * FROM (
				SELECT
				    tt.name AS test_name,
				    m.name AS measure_name,
				    mr.alphanumeric AS result,
					s.gender,
				    count(DISTINCT
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id
				    		AND floor(datediff(t.time_created,p.dob)/365.25)<$lowAgeBound),t.id,NULL)) AS RC_U_5,
				    count(DISTINCT
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)>=$lowAgeBound 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)<$midAgeBound),t.id,NULL)) AS RC_5_15,
				    count(DISTINCT
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)>=$midAgeBound),t.id,NULL)) AS RC_A_15
				FROM test_types tt
				    INNER JOIN testtype_measures tm ON tt.id = tm.test_type_id
				    INNER JOIN measures m ON tm.measure_id = m.id
					CROSS JOIN (SELECT 0 AS id, 'Male' AS gender UNION SELECT 1, 'Female') AS s
				    INNER JOIN measure_ranges mr ON tm.measure_id = mr.measure_id
					LEFT JOIN tests AS t ON t.test_type_id = tt.id
				    INNER JOIN visits v ON t.visit_id = v.id
				    INNER JOIN patients p ON v.patient_id = p.id
				    INNER JOIN test_results tr ON t.id = tr.test_id AND m.id = tr.measure_id
				WHERE (t.test_status_id=4 OR t.test_status_id=5) AND m.measure_type_id = 2
					AND t.time_created BETWEEN ? AND ? $testCategoryWhereClause
				GROUP BY tt.id, m.id, mr.alphanumeric, s.id) AS alpha
				UNION
				(
				SELECT
					tt.name test_name,
					mmr.name measure_name,
					mmr.result_alias result,
					s.gender,
					count(DISTINCT 
						IF((mmr.result_alias = 'High' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $lowAgeBound AND tr.result > mmr.range_upper 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Normal' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $lowAgeBound AND tr.result >= mmr.range_lower 
							AND tr.result <= mmr.range_upper AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Low' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $lowAgeBound AND tr.result < mmr.range_lower 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,NULL)))) RC_U_5,
					count(DISTINCT 
						IF((mmr.result_alias = 'High' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $lowAgeBound 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $midAgeBound 
							AND tr.result > mmr.range_upper AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Normal' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $lowAgeBound 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $midAgeBound 
							AND tr.result >= mmr.range_lower AND tr.result <= mmr.range_upper 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Low' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $lowAgeBound 
							AND floor(datediff(t.time_created,p.dob)/365.25) < $midAgeBound 
							AND tr.result < mmr.range_lower 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,NULL)))) RC_5_15,
					count(DISTINCT 
						IF((mmr.result_alias = 'High' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $midAgeBound 
							AND tr.result > mmr.range_upper 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Normal' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $midAgeBound 
							AND tr.result >= mmr.range_lower AND tr.result <= mmr.range_upper
							 AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							 AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							 AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,
						IF((mmr.result_alias = 'Low' AND p.gender = s.id 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= $midAgeBound 
							AND tr.result < mmr.range_lower 
							AND floor(datediff(t.time_created,p.dob)/365.25) >= mmr.age_min 
							AND floor(datediff(t.time_created,p.dob)/365.25) < mmr.age_max 
							AND (p.gender = mmr.gender OR mmr.gender = 2)),t.id,NULL)))) RC_A_15
				FROM test_types tt
					INNER JOIN testtype_measures tm ON tt.id = tm.test_type_id
					CROSS JOIN (SELECT 0 AS id, 'Male' AS gender UNION SELECT 1, 'Female') AS s
					INNER JOIN (
						SELECT m.name, m.measure_type_id, mr.*, i.* 
						FROM measures m INNER JOIN measure_ranges mr ON m.id = mr.measure_id 
						CROSS JOIN (SELECT 'High' AS result_alias UNION SELECT 'Normal' UNION SELECT 'Low') AS i 
						WHERE m.measure_type_id = 1) mmr ON tm.measure_id = mmr.measure_id
					LEFT JOIN tests AS t ON t.test_type_id = tt.id
					INNER JOIN visits v ON t.visit_id = v.id
					INNER JOIN patients p ON v.patient_id = p.id
					INNER JOIN test_results tr ON t.id = tr.test_id AND tm.measure_id = tr.measure_id
				WHERE (t.test_status_id=4 OR t.test_status_id=5) AND mmr.measure_type_id = 1 
					AND t.time_created BETWEEN ? AND ? $testCategoryWhereClause
				GROUP BY tt.id, tm.measure_id, mmr.result_alias, s.id) 
			ORDER BY test_name, measure_name, result, gender",
			array($startTime, $endTime, $startTime, $endTime)
			);

		return $data;
	}

	/**
	* Search for tests meeting the given criteria
	*
	* @param String $searchString
	* @param String $testStatusId
	* @param String $dateFrom
	* @param String $dateTo
	* @return Collection 
	*/
	public static function search($searchString = '', $testStatusId = 0, $dateFrom = NULL, $dateTo = NULL){
		$dbQuery = 'select t.id as test_id, t.interpretation, t.test_status_id, t.verified_by, t.tested_by, t.time_created, v.id as visit_id, v.visit_number, v.visit_type, p.patient_number, p.name as patient_name, p.dob, p.gender, p.external_patient_number, tt.name as testtype_name, sp.id as specimen_id, sp.referral_id, sp.specimen_status_id, st.name, tst.name, ref.status as ref_status, count(tsp.specimen_type_id) as specimenTypesCount, tc.name as testCategoryName from tests t 
			inner join visits v on t.visit_id = v.id 
			inner join patients p on v.patient_id = p.id  
			inner join test_types tt on t.test_type_id = tt.id 
			inner join test_categories tc on tt.test_category_id = tc.id 
			inner join specimens sp on t.specimen_id = sp.id 
			inner join specimen_types st on sp.specimen_type_id = st.id 
			inner join test_statuses tst on t.test_status_id = tst.id 
			inner join testtype_specimentypes tsp on tt.id = tsp.test_type_id
			left join referrals ref on sp.referral_id = ref.id ';
			if ($searchString != ''){
				$dbQuery .= 'where 
				(tt.name LIKE ? and tt.deleted_at is null or 
				(p.name like ? or p.external_patient_number = ? or 
				p.patient_number = ? and p.deleted_at is null) or 
				(sp.id = ?) or 
				(v.visit_number = ?)) ';
			}
				if($testStatusId != 0){
					$dbQuery .= ' and t.test_status_id = ? ';//Filter by test status
				}
			if($dateFrom || $dateTo){
				if ($dateFrom){
					$dbQuery .= ' and t.time_created >= ? ';//Filter by test status
				}
				if ($dateTo){
					$dateTo = $dateTo . ' 23:59:59';
					$dbQuery .= ' and t.time_created <= ? ';//Filter by test status
				}
			}
			$dbQuery .= 
			'group by t.id
			order by t.time_created DESC LIMIT 50';


		if($searchString != ''){
			if($testStatusId != 0){
				if($dateFrom || $dateTo){
					if ($dateFrom && $dateTo){
						$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $testStatusId, $dateFrom, $dateTo) );
					}
					else if ($dateFrom){
						$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $testStatusId, $dateFrom) );
					}
					else if ($dateTo){
						$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $testStatusId, $dateTo) );
					}
				}
				else {
					$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $testStatusId) );
				}
			}
			else if($dateFrom || $dateTo){
				if ($dateFrom  && $dateTo){
						$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $dateFrom, $dateTo) );
				}
				else if ($dateFrom){
					$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $dateFrom) );
				}
				else if ($dateTo){
					$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString, $dateTo) );
				}
			}
			else {

				$tests = DB::select(DB::raw($dbQuery), array("%".$searchString . "%", "%".$searchString . "%" , $searchString , $searchString , $searchString , $searchString) );
			}
		}
		else {
			$tests = DB::select(DB::raw($dbQuery));
		}


		foreach ($tests as $key => $test) {
			$at = new DateTime('now');
			$dateOfBirth = new DateTime($test->dob);
			$interval = $dateOfBirth->diff($at);

			//Set patients age
			$age = $interval->y;
			$test->age = $age;
			//Not from the external system
			if($test->external_patient_number == null) {
				$test->isPaid = true;
			}
			//Checking if the patient has paid
			elseif( $test->$age >= 6
				&& $externalDump->order_stage == "op" 
				&& $externalDump->receipt_number == "" 
				&& $externalDump->receipt_type == ""  )
				$test->isPaid = false;
			else 
				$test->isPaid = true;

			//Get gender of the patient
			if ($test->gender == Patient::MALE){
				$test->gender = 'M';
			}
			else if ($test->gender == Patient::FEMALE){
				$test->gender = 'F';
			}
			//SpecimenID
			$test->specimen_id = substr($test->testCategoryName, 0 , 3).'-'.$test->specimen_id;
		}
		return $tests;
	}

	/**
	 * Get the Surveillance Data
	 *
	 * @return db resultset
	 */
	public static function getSurveillanceData($from, $to)
	{
		$diseases = Disease::all();

		$surveillances = array();

		$testTypeIds = array();

		//Foreach disease create a query string for the different test types
		foreach (Disease::all() as $disease) {
			$count = 0;
			$testTypeQuery = '';
			//For a single disease creating a query string for it's different test types
			foreach ($disease->reportDiseases as $reportDisease) {
				if ($count == 0) {
					$testTypeQuery = 't.test_type_id='.$reportDisease->test_type_id;
				} else {
					$testTypeQuery = $testTypeQuery.' or t.test_type_id='.$reportDisease->test_type_id;
				}
				$testTypeIds[] = $reportDisease->test_type_id;
				$count++;
			}

			//For a single disease holding the test types query string and disease id
			if (!empty($testTypeQuery)) {
				$surveillances[$disease->id]['test_type_id'] = $testTypeQuery;
				$surveillances[$disease->id]['disease_id'] = $disease->id;
			}
		}

		//Getting an array of measure ids from an array of test types
		$measureIds = Test::getMeasureIdsByTestTypeIds($testTypeIds);

		//Getting an array of positive interpretations from an array of measure ids
		$positiveRanges = Test::getPositiveRangesByMeasureIds($measureIds);

		$idCount = 0;
		$positiveRangesQuery = '';

		//Formating the positive ranges into part of the the query string
		foreach ($positiveRanges as $positiveRange) {
			if ($idCount == 0) {
				$positiveRangesQuery = "tr.result='".$positiveRange."'";
			} else {
				$positiveRangesQuery = $positiveRangesQuery." or tr.result='".$positiveRange."'";
			}
			$idCount++;
		}

		// Query only if there are entries for surveillance
		if (!empty($surveillances) && !empty($positiveRangesQuery)) {
			//Select surveillance data for the defined diseases
			$query = "SELECT ";
			foreach ($surveillances as $surveillance) {
				$query = $query.
					"COUNT(DISTINCT if((".$surveillance['test_type_id']."),t.id,NULL)) as ".$surveillance['disease_id']."_total,".
					"COUNT(DISTINCT if(((".$surveillance['test_type_id'].
						") and DATE_SUB(NOW(), INTERVAL 5 YEAR)<p.dob),t.id,NULL)) as ".$surveillance['disease_id']."_less_five_total, ".
					"COUNT(DISTINCT if(((".$surveillance['test_type_id'].") and (".$positiveRangesQuery.
						")),t.id,NULL)) as ".$surveillance['disease_id']."_positive,".
					"COUNT(DISTINCT if(((".$surveillance['test_type_id'].") and (".$positiveRangesQuery.
						") and DATE_SUB(NOW(), INTERVAL 5 YEAR)<p.dob),t.id,NULL)) as ".$surveillance['disease_id'].
							"_less_five_positive";

			    //Add no comma if it is the last variable in the array
			    if($surveillance == end($surveillances)) {
			        $query = $query." ";
			    }else{
			        $query = $query.", ";
			    }
			}

			$query = $query." FROM tests t ".
				"INNER JOIN test_results tr ON t.id=tr.test_id ".
				"JOIN visits v ON v.id=t.visit_id ".
				"JOIN patients p ON v.patient_id=p.id ";
				if ($from) {
					$query = $query."WHERE (time_created BETWEEN '".$from."' AND '".$to."')";
				}

			$data = DB::select($query);
			$data = json_decode(json_encode($data), true);
			return $data[0];
		}else{
			return null;
		}
	}

	/**
	 * @param  Measure IDs $measureIds array()
	 * @return Ranges whose interpretation is positive $positiveRanges array()
	 */
	public static function getPositiveRangesByMeasureIds($measureIds)
	{
		$positiveRanges = array();

		foreach ($measureIds as $measureId) {

			$measure = Measure::find($measureId);

			$measureRanges = $measure->measureRanges;

			foreach ($measureRanges as $measureRange) {

				if ($measureRange->interpretation == Test::POSITIVE) {
					$positiveRanges[] = $measureRange->alphanumeric;
				}
			}
		}

		return $positiveRanges;
	}

	/**
	 * @param  Test Type IDs $testTypeIds array()
	 * @return Measure IDs $measureIds array()
	 */
	public static function getMeasureIdsByTestTypeIds($testTypeIds)
	{
		$measureIds = array();
		foreach ($testTypeIds as $testTypeId) {

			$testType = TestType::find($testTypeId);
			$measureIds = array_merge($measureIds, $testType->measures->lists('id'));
		}
		return $measureIds;
	}
	/**
	 * External dump relationship
	 */
	public function external(){
		return ExternalDump::where('lab_no', '=', $this->external_id)->get()->first();
	}
}