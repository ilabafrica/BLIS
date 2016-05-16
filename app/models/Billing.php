<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Billing extends Eloquent
{
	/**
	 * Enabling soft deletes for billing settings.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'billing';
}