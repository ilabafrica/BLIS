<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Patient extends Eloquent
{

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

    public function search($keyword){
    	return static::where('id', 'LIKE', '%$' . $keyword . '%')
						->orWhere('name', 'LIKE', '%$' . $keyword . '%')
						->orWhere('patient_number', 'LIKE', '%$'.$keyword.'%')
						->orWhere('external_patient_number', 'LIKE', '%$'.$keyword.'%')->paginate(5);
    }

}