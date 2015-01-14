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
	/**
	* Return the counts for a specimen type given the specimen_status_id, and date range for ungrouped specimen 
	*
	* @param $specimenStatusID, $from, $to
	*/
	public function countPerStatus($specimenStatusID, $from = null, $to = null)
	{

		$specimens = Specimen::where('specimen_type_id', $this->id)->whereIn('specimen_status_id', $specimenStatusID);
		if($to && $from){
			if(in_array($specimenStatusID, [Specimen::REJECTED]))
				$specimens = $specimens->whereBetween('time_rejected', [$from, $to]);
			else
				$specimens = $specimens->whereBetween('time_accepted', [$from, $to]);
		}

		return $specimens->count();

	}
	/**
	* Returns grouped specimen Counts with optional gender, age range, date range
	*
	* @param $gender, $ageRange, $from, $to
	*/
	public function groupedSpecimenCount($gender=null, $ageRange=null, $from=null, $to=null){
			$specimens = $this->specimen->filter(function($specimen){
				if (in_array($specimen->specimen_status_id, [Specimen::ACCEPTED])){
					return true;
				}
				return false;
			});
			if($to && $from){
				$specimens = $specimens->filter(function($specimen) use($to, $from){
					$timeCreated = strtotime($specimen->time_accepted);
					if(strtotime($from) < $timeCreated && strtotime($to) >= $timeCreated)
						return true;
					else return false;
				});
			}
			if($gender){
				$specimens = $specimens->filter(function($specimen) use ($gender){

				if (in_array($specimen->test->visit->patient->gender, $gender)){
					return true;
				}
				else return false;
				});
			}
			if($ageRange){
				$ageRange = explode('-', $ageRange);
				$ageStart = $ageRange[0];
				$ageEnd = $ageRange[1];
				$specimens = $specimens->filter(function($specimen) use ($ageStart, $ageEnd){
					$dateOfBirth = new DateTime($specimen->test->visit->patient->dob);
					$now = new DateTime('now');
					$interval = $dateOfBirth->diff($now);

				if ($interval->y >= $ageStart && $interval->y < $ageEnd){
					return true;
					}
					else return false;
				});
			}

		return $specimens->count();
	}
}