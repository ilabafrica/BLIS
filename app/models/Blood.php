<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Blood extends Eloquent
{
	/**
	 * Enabling soft deletes for blood bank.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blood_bank';
}