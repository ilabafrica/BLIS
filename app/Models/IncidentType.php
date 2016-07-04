<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentType extends Model
{
	/**
	 * Enabling soft deletes for victim type details.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'incident_types';

	/**
	 * incidents relationship
	 */
	public function incidents()
	{
	  return $this->hasMany('App\Models\Incident');
	}
}