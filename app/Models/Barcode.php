<?php namespace App\Models;
// todo: create tests for this class

use Illuminate\Database\Eloquent\SoftDeletes;

class Barcode extends Eloquent
{
	/**
	 * Enabling soft deletes for barcode settings.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'barcode_settings';
}

