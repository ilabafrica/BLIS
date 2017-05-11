<?php

class TestResult extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_results';

	public $timestamps = false;

	/**
	 * Mass assignment fields
	 */
	protected $fillable = array('test_id', 'measure_id', 'result');

	/**
	 * Test  relationship
	 */
	public function test()
	{
		return $this->belongsTo('Test');
	}

	/**
	 * Result attribute mutator
	 */
	public function getResultAttribute($val)
	{
		return htmlspecialchars($val);
	}
	/**
	 * Results Audit relationship
	 */
	public function auditResults()
	{
		return $this->hasMany('AuditResult');
	}
	/*
	*	Counts for microbiology - count organisms per specimen type
	*
	*/
	public static function microCounts($result, $specimen, $from, $to){
		$count = DB::select('SELECT count(tr.id) as total '.
							'FROM test_results tr, tests t, testtype_measures tpm, testtype_specimentypes tst, specimen_types st '.
							'WHERE tr.test_id = t.id '.
							'AND t.test_type_id=tpm.test_type_id '.
							'AND tr.measure_id=tpm.measure_id '.
							'AND t.test_type_id = tst.test_type_id '.
							'AND tst.specimen_type_id=st.id '.
							'AND st.name like '."'%".$specimen."%'".
							' AND tr.result like '."'Growth of %".$result."%'".
							' AND tr.time_entered BETWEEN '."'".$from."'".' AND '."'".$to->format('Y-m-d')."'".';');
		return $count;
	}
	/**
	* relationship between result and measure
	*/
	public function measure()
	{
		return $this->belongsTo('Measure');
	}
}
