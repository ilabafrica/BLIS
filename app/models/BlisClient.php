<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class BlisClient extends Eloquent
{
	/**
	 * Enabling soft deletes for interfaced equipment.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'interfaced_equipment';
	// Constants for 
	const UNIDIRECTIONAL = 1;
	const BIDIRECTIONAL = 2;
	/*
	*	Constants for feed source RS232,TCP/IP, MSACCESS,HTTP,TEXT
	*/
	const RS232 = 0;
	const TCPIP = 1;
	const MSACCESS = 2;
	const HTTP = 3;
	const TEXT = 4;
	/**
	 * TestCategory relationship
	 */
	public function testCategory()
	{
		return $this->belongsTo('TestCategory', 'lab_section');
	}
	/**
	 * Get feed source
	 */
	public function feed($source)
	{
		if($source == BlisClient::RS232)
			return 'RS232';
		else if($source == BlisClient::TCPIP)
			return 'TCP/IP';
		else if($source == BlisClient::MSACCESS)
			return 'MSACCESS';
		else if($source == BlisClient::HTTP)
			return 'HTTP';
		else if($source == BlisClient::TEXT)
			return 'TEXT';
	}
	/**
	 * Get communication type
	 */
	public function comm($type)
	{
	  	if($type == BlisClient::UNIDIRECTIONAL)
	  		return trans('messages.uni');
	  	else
	  		return trans('messages.bi');
	}

	/**
	* Given the Client name we return the Client ID
	*
	* @param $clientname the name of the Client
	*/
	public static function getClientIdByName($name)
	{
		try 
		{
			$name = trim($name);
			$client = BlisClient::where('equipment_name', 'like', $name)->orderBy('equipment_name')->firstOrFail();
			return $client->id;
		} catch (ModelNotFoundException $e) 
		{
			Log::error("The Client ` $name ` does not exist:  ". $e->getMessage());
			//TODO: send email?
			return null;
		}
	}
}