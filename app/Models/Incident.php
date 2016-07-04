<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
	/**
	 * Enabling soft deletes for incidents.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'incidents';
	/**
	 * Incident type relationship
	 */
	public function incidentType()
	{
	  return $this->belongsTo('App\Models\IncidentType');
	}
	/**
	 * victim relationship
	 */
	public function victim()
	{
	  return $this->belongsTo('App\Models\Victim');
	}
	/**
	 * sop relationship
	 */
	public function sop()
	{
	  return $this->belongsTo('App\Models\Sop');
	}
}