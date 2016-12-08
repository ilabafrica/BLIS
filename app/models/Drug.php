<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Drug extends Eloquent
{
	/**
	 * Enabling soft deletes for drugs.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'drugs';
        /**
	* Given the drug name we return the drug ID
	*
	* @param $drugName the name of the drug
	*/
	public static function getDrugIdByName($drugName)
	{
		try 
		{
			$drugName = trim($drugName);
			$drug = Drug::where('name', 'like', '%'.$drugName.'%')->orderBy('name')->firstOrFail();
			return $drug->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The Drug ` $drugName ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}