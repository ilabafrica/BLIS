<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryReceipt extends Eloquent
{
	
	protected $table = 'inventory_receipts';

	public function getTotalReceipts()
	{
		$totalReceipts = DB::table('inventory_receipts')->sum('qty');
	}

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('InventoryCommodity', 'id');
	}

	/**
	* Supplier relationship
	*/
	public function supplier()
	{
		return $this->belongsTo('InventorySupplier', 'id');
	}
}