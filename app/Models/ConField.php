<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConField extends Model
{
	/**
	 * Enabling soft deletes for analysers.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'configurable_fields';
	/**
	 * settings relationship
	 */
	public function setting()
	{
		return $this->hasOne('App\Models\LabConfig', 'key');
	}
}