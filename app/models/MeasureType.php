<?php

class MeasureType extends Eloquent
{
    const numeric = 1;
    const alphanumeric = 2;
    const Autocomplete = 3;
    const free_text = 4;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_types';

	/**
	 * Measure relationship
	 */
    public function measures()
    {
        return $this->hasMany('Measure');
    }

}