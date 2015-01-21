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
	public static function getInfectionData($startTime, $endTime){
		$lowAgeBound = 5;
		$midAgeBound = 14;
		
		$data = DB::select(
			"SELECT * FROM (
				SELECT
				    tt.name AS test_name,
				    m.name AS measure_name,
				    mr.alphanumeric AS result,
					s.gender,
				    count(
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id
				    		AND floor(datediff(t.time_created,p.dob)/365.25)<$lowAgeBound),1,null)) AS RC_U_5,
				    count(
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)>=$lowAgeBound 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)<$midAgeBound),1,null)) AS RC_5_15,
				    count(
				    	IF((tr.result = mr.alphanumeric AND p.gender=s.id 
				    		AND floor(datediff(t.time_created,p.dob)/365.25)>=$midAgeBound),1,null)) AS RC_A_15
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
					AND t.time_created BETWEEN ? AND ?
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
				WHERE mmr.measure_type_id = 1 AND t.time_created BETWEEN ? AND ?
				GROUP BY tt.id, tm.measure_id, mmr.result_alias, s.id) 
			ORDER BY test_name, measure_name, result, gender",
			array($startTime, $endTime, $startTime, $endTime)
			);

		return $data;
	}
}