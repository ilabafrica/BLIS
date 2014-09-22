<?php

class MeasureType extends Eloquent
{
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_types';

	/**
	 * Enabling soft deletes for patient details.
	 *
	 * @var boolean
	 */
	public $timestamps = false;
}