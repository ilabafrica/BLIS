<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Victim extends Model
{
	/**
	 * Enabling soft deletes for victims.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'victims';
	/**
	 * Victim type relationship
	 */
	public function victimType()
	{
	  return $this->belongsTo('App\Models\VictimType');
	}
}