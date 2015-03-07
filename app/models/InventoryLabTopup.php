<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryLabTopup extends Eloquent {

	protected $table = 'inventory_labtopup';

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('InventoryCommodity', 'id');
	}

	/**
	* Relationship between commodity and the user who handled it
	*/
	public function user(){
		return $this->belongsTo('user');
	}
}