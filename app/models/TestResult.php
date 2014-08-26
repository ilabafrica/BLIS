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

}