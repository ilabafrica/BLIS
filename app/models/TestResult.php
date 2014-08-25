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
	 * Test  relationship
	 */
	public function test()
	{
		return $this->belongsTo('Test');
	}
}