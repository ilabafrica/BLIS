<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryCommodity extends Eloquent
{

	protected $table = 'inventory_commodities';
	public $timestamps = false;

	public function getCommodityIdbyName()
	{
		return $this->hasMany('inventory_receipts');
	}

	/*
	* Relationship between receipts and 
	*/
	public function receipts()
	{
		return $this->hasMany('InventoryReceipt');
	}
}