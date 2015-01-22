<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Patient extends Eloquent
{
	const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;
	/**
	 * Enabling soft deletes for patient details.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'patients';

	/**
	 * Visits relationship
	 */
    public function visits()
    {
        return $this->hasMany('Visit');
    }

	/**
	 * Patient Age 
	 *
	 * @return String x years y months
	 */
	public function getAge($shortForm=false)
	{
		$dateOfBirth = new DateTime($this->dob);
		$now = new DateTime('now');
		$interval = $dateOfBirth->diff($now);

		return $shortForm ? $interval->y : $interval->y." years " . $interval->m ." months";
	}

	/**
	* Get patient's gender
	*
	* @param optional boolean $shortForm - return abbreviation (M/F). Default true
	* @return String gender 
	*/
	public function getGender($shortForm=true)
	{
		if ($this->gender == Patient::MALE)
		{
			return $shortForm?"M":trans("messages.male");
		}
		else if ($this->gender == Patient::FEMALE)
		{
			return $shortForm?"F":trans("messages.female");
		}
	}

	/**
	* Search for patients meeting given criteria
	*
	* @param String $searchText
	* @return Collection 
	*/
	public static function search($searchText)
	{
		return Patient::where('patient_number', 'LIKE', '%'.$searchText.'%')
						->orWhere('name', 'LIKE', '%'.$searchText.'%')
						->orWhere('external_patient_number', 'LIKE', '%'.$searchText.'%');
	}
}