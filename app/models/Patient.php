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
	 */
	public function getAge()
	{
		$dateOfBirth = new DateTime($this->dob);
		$now = new DateTime('now');
		$interval = $dateOfBirth->diff($now);

		return $interval->y ." years " . $interval->m ." months";
	}

	/**
	* Function to return patients gender
	*	TODO : add parameter to return full gender `Male` or short form `M`
	* 	     : Translations
	*/
	public function getGender()
	{
		if ($this->gender == Patient::MALE)
		{
			return "M";
		}
		else if ($this->gender == Patient::FEMALE)
		{
			return "F";
		}
	}
}