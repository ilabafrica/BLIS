<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Critical extends Model
{
	/**
	 * Enabling soft deletes for chemistry/hematology critical values.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'critical';
	/**
	 * Measures relationship
	 */
	public function measure()
	{
	  return $this->belongsTo('App\Models\Measure', 'parameter');
	}
}
