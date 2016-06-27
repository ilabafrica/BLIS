<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'diseases';

	public $timestamps = false;

	/**
	 * Report Configuration relationship
	 */
	public function reportDiseases()
	{
	  return $this->hasMany('App\Models\ReportDisease');
	}
}