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
	 * confield relationship
	 */
    public function confield()
    {
        return $this->hasMany('App\Models\ConField');
    }
	/**
	 * value given for config
	 */
	public function conf($id)
	{
		return $this->confield()->where('configurable_id', $id)->first();
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
	/*
	*	Constants for fields given the feed source
	*/
	const RS232 = ['COMPORT', 'BAUD_RATE', 'PARITY', 'STOP_BITS', 'APPEND_NEWLINE', 'DATA_BITS', 'APPEND_CARRIAGE_RETURN'];
	const TCPIP = ['PORT', 'MODE', 'CLIENT_RECONNECT', 'EQUIPMENT_IP'];
	const MSACCESS = ['DATASOURCE', 'DAYS'];
	const HTTP = [];
	const TEXT = ['BASE_DIRECTORY', 'USE_SUB_DIRECTORIES', 'SUB_DIRECTORY_FORMAT', 'FILE_NAME_FORMAT', 'FILE_EXTENSION', 'FILE_SEPERATOR'];

	/**
	* Return field ID given the name
	* @param $name the name of the field
	*/
	public static function idByName($name = NULL)
	{
		if($name)
		{
			try 
			{
				$field = Field::where('field_name', $name)->orderBy('field_name', 'asc')->firstOrFail();
				return $field->id;
			} 
			catch (ModelNotFoundException $e) 
			{
				Log::error("The field ` $name ` does not exist:  ". $e->getMessage());
				//TODO: send email?
				return null;
			}
		}
		else
		{
			return null;
		}
	}
}