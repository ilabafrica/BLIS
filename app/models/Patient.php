
<?php

class Patient extends Eloquent
{
	use SoftDeletingTrait;
    	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patients';

	/**
	 * Enabling soft deletes for patient details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;
}