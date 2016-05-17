<?php

class Visit extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'visits';

	public $timestamps = true;

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('Test');
    }

	/**
	 * Patient relationship
	 */
	public function patient()
	{
		return $this->belongsTo('Patient');
	}
	/**
	 * Patient visit cost
	 */
	public function cost()
	{
		$total = 0;
		foreach($this->tests as $test)
		{
			$total+=(double)$test->testType->cost();
		}
		return $total;
	}
}
