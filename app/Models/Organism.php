<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class Organism extends Model
{
	/**
	 * Enabling soft deletes for organisms.
	 *
	 */
	use SoftDeletes;
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
	  return $this->belongsToMany('App\Models\Drug', 'organism_drugs');
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
}