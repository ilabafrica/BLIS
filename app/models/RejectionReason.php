<?php

class RejectionReason extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rejection_reasons';

	public $timestamps = false;

	/**
	 * Specimen relationship
	 */
	public function specimen()
	{
		return $this->hasMany('Specimen');
	}
}