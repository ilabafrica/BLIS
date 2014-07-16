<?php

class MeasureType extends Eloquent
{
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
	protected $softDelete = true;

	public $timestamps = false;
}