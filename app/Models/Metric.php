<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metric extends Model
{
	/**
	 * Enabling soft deletes for metrics.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	protected $table = 'metrics';
}