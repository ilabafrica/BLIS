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
	/**
	 * Billing status
	 *
	 */
	const ENABLED = 1;
	const DISABLED = 0;
	/**
	 * Check billing status - enabled/disabled
	 *
	 */
	public static function isEnabled()
	{
		$billing = Billing::first();
		if($billing->enabled == Billing::ENABLED)
			return true;
		else 
			return false;
	}
}