<?php

class TestStatus extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
    const pending = 1;
    const started = 2;
    const completed = 3;
    const verified = 4;
    const cancelled = 5;
	protected $table = 'test_statuses';

	public $timestamps = false;

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('Test');
    }

	/**
	 * TestPhase relationship
	 */
	public function testPhase()
	{
		return $this->belongsTo('TestPhase');
	}
}