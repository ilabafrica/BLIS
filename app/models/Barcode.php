<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Barcode extends Eloquent
{
	/**
	 * Enabling soft deletes for barcode settings.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'barcode_settings';
}