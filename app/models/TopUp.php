<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
/**
* Class for holding topup requests from the bench to the inventory
*/
class TopUp extends Eloquent {

	protected $table = 'topups';

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('Commodity', 'id');
	}

	/**
	* Relationship between commodity and the user who handled it
	*/
	public function user(){
		return $this->belongsTo('user');
	}
}