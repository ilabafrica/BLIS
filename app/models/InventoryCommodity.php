<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryCommodity extends Eloquent
{

	protected $table = 'inventory_commodities';

	/**
	* Relationship between receipts and 
	*/
	public function receipts()
	{
		return $this->hasMany('InventoryReceipt');
	}

	/**
	* Relationship between commodity and the user who handled it
	*/
	public function user(){
		return $this->hasOne('user');
	}

	public function metric()
	{
		return $this->belongsTo('Metric', 'id');
	}
}