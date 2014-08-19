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
	 * User relationship
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}

}