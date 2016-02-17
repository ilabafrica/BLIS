<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configurable extends Model
{
	/**
	 * Enabling soft deletes for configurables.
	 *
	 */
	use SoftDeletes;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'configurables';
	/**
	 * Fields relationship
	 */
	public function fields()
	{
		return $this->hasMany('App\Models\Field');
	}
	/**
	* Return Configurable ID given the name
	* @param $name the name of the module
	*/
	public static function idByRoute($name = NULL)
	{
		if($name)
		{
			if($name)
			{
				try 
				{
					$conf = Configurable::where('route', $name)->orderBy('name', 'asc')->firstOrFail();
					return $conf->id;
				} 
				catch (ModelNotFoundException $e) 
				{
					Log::error("The Configurable with route ` $name ` does not exist:  ". $e->getMessage());
					//TODO: send email?
					return null;
				}
			}
		}
		else{
			return null;
		}
	}
}