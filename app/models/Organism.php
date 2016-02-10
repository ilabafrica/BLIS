<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Organism extends Eloquent
{
	/**
	 * Enabling soft deletes for organisms.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'organisms';
	/**
	 * Drugs relationship
	 */
	public function drugs()
	{
	  return $this->belongsToMany('Drug', 'organism_drugs');
	}
	/**
	 * Set compatible drugs
	 *
	 * @return void
	 */
	public function setDrugs($drugs){

		$drugsAdded = array();
		$organismID = 0;	

		if(is_array($drugs)){
			foreach ($drugs as $key => $value) {
				$drugsAdded[] = array(
					'organism_id' => (int)$this->id,
					'drug_id' => (int)$value,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
					);
				$organismID = (int)$this->id;
			}

		}
		// Delete existing test_type measure mappings
		DB::table('organism_drugs')->where('organism_id', '=', $organismID)->delete();

		// Add the new mapping
		DB::table('organism_drugs')->insert($drugsAdded);
	}
	/**
	 * Drug-susceptibility relationship
	 */
	public function susceptibility()
	{
	  return $this->hasMany('Susceptibility');
	}
	/**
	 * sensitivity relationship for a single test
	 */
	public function sensitivity($id)
	{
	  return $this->susceptibility()->where('test_id', $id)->count();
	}
}