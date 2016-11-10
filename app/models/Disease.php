<?php

class Disease extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'diseases';

	public $timestamps = false;

	/**
	 * Report Configuration relationship
	 */
	public function reportDiseases()
	{
	  return $this->hasMany('ReportDisease');
	}

}