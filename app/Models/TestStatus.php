<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestStatus extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_statuses';

	public $timestamps = false;

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('App\Models\Test');
    }

	/**
	 * TestPhase relationship
	 */
	public function testPhase()
	{
		return $this->belongsTo('App\Models\TestPhase');
	}
}