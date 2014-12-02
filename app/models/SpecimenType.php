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
	 * TestType relationship
	 */
	public function specimen()
	{
	  return $this->hasMany('Specimen');
	}
	/**
	* Return the counts for a specimen type given the specimen_status_id, and date range for ungrouped specimen 
	*
	* @param $specimenStatusID, $from, $to
	*/
	public function countPerStatus($specimenStatusID, $from = null, $to = null)
	{

		$specimens = $this->specimen->filter(function($specimen) use ($specimenStatusID){

				if (in_array($specimen->specimen_status_id, $specimenStatusID)){
					return true;
				}
				return false;
			});

		if($to && $from){
			$specimens = $specimens->filter(function($specimen) use($to, $from, $specimenStatusID){
				if(in_array($specimenStatusID, [Specimen::REJECTED]))
					$timeCreated = strtotime($specimen->time_rejected);
				else
					$timeCreated = strtotime($specimen->time_accepted);
				if(strtotime($from) < $timeCreated && strtotime($to) >= $timeCreated)
					return true;
				else return false;
			});
		}

		return $specimens->count();

	}
}