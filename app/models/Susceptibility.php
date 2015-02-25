<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Susceptibility extends Eloquent
{
	/**
	 * Enabling soft deletes for drug susceptibility.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'drug_susceptibility';
	/**
	 * User relationship
	 */
	public function user()
	{
	  return $this->belongsTo('User', 'user_id');
	}
	/**
	 * Test relationship
	 */
	public function test()
    {
        return $this->hasOne('Test', 'test_id');
    }
    /**
	 * Organism_drug relationship
	 */
	/*public function organismDrug()
    {
        return $this->hasMany('Test');
    }*/
}