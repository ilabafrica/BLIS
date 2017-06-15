<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Patient extends Eloquent
{
	const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;
	const UNKNOWN = 3;
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
	 * @param optional String - format [Y|YY|YYMM]
	 * @param optional Timestamp - age as at this date
	 * @return String x years y months
	 */
	public function getAge($format = "YYMM", $at = NULL)
	{
		if(!$at)$at = new DateTime('now');

		$dateOfBirth = new DateTime($this->dob);
		$interval = $dateOfBirth->diff($at);

		$age = "";

		switch ($format) {
			case 'Y':
				$age = $interval->y;break;
			case 'M':
				$age = $interval->m;break;
			case 'D':
				$age = $interval->d;break;
			case 'YY':
				$age = $interval->y ." years ";break;
			default:
				$age = ($interval->y > 0)?$interval->y ." years ":"";
				$age .= ($interval->m > 0)?$interval->m ." months ":"";
				$age .= ($interval->d > 0)?$interval->d." days":"";
				break;
		}

		return $age;
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
		return Patient::where('patient_number', '=', $searchText)
						->orWhere('name', 'LIKE', '%'.$searchText.'%')
						->orWhere('external_patient_number', '=', $searchText);
	}
}