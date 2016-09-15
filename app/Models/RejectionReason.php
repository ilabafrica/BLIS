<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RejectionReason extends Model
{
	use SoftDeletes;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rejection_reasons';

	public $timestamps = false;

	/**
	 * Specimen relationship
	 */
	public function specimen()
	{
		return $this->hasMany('App\Models\Specimen');
	}
}