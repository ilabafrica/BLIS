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
	 * Class constants 
	 *
	 */
	const NUMERIC_RANGE = 1;
	const ALPHANUMERIC = 2;
	const AUTOCOMPLETE = 3;
	const FREE_TEXT = 4;
}