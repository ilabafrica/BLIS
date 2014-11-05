<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SpecimenType extends Eloquent
{
	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'specimen_types';

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->belongsToMany('TestType', 'testtype_specimentypes');
	}

	/**
	 * Specimen relationship
	 */
	public function specimen()
	{
	  return $this->hasMany('Specimen');
	}
}