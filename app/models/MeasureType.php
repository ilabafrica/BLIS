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
	 * Measure relationship
	 */
    public function measures()
    {
        return $this->hasMany('Measure');
    }
	/**
	 * Enabling revisionable
	 *
	 */
	use Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionEnabled = true;
}