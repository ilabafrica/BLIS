<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VictimType extends Model
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
	protected $table = 'victim_types';

	/**
	 * Victims relationship
	 */
	public function victims()
	{
	  return $this->hasMany('App\Models\Victim');
	}
}