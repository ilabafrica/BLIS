<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasureRange extends Model
{
	//	Constants for numeric ranges i.e. Low, Normal, High
	const LOW = 0;
	const NORMAL = 1;
	const HIGH = 2;
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_ranges';

	public $timestamps = false;


	/**
	 * Class constants 
	 *
	 */
	const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;

	/**
	 * Measure relationship
	 */
	public function measure()
	{
	  return $this->belongsTo('Measure');
	}
}