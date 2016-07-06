<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
	/**
	 * Enabling soft deletes for follow ups.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'follow_ups';
	/**
	 * Incident relationship
	 */
	public function incident()
	{
	  return $this->belongsTo('App\Models\Incident');
	}
}