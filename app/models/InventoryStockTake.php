<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryStockTake extends Eloquent
{
	
	protected $table = 'inventory_stocktake';
	public $timestamps = false;

}