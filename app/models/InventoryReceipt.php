<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryReceipt extends Eloquent
{
	
	protected $table = 'inventory_receipts';
	public $timestamps = false;

	public function getTotalReceipts()
	{
		$totalReceipts = DB::table('inventory_receipts')->sum('qty');
	}
}