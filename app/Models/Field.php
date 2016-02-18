<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
	/**
	 * Enabling soft deletes for configurable_fields.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fields';
	/**
	 * settings relationship
	 */
	public function setting()
	{
		return $this->hasOne('App\Models\LabConfig', 'key');
	}
	/*
	*	Constants for type of field
	*/
	const CHECKBOX = 0;
	const FILEBROWSER = 1;
	const RADIOBUTTON = 2;
	const SELECTLIST = 3;
	const TEXTFIELD = 4;
	const TEXTAREA = 5;
}