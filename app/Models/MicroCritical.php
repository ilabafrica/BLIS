<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MicroCritical extends Model
{
	/**
	 * Enabling soft deletes for microbiology critical values.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'micro_critical';
}
