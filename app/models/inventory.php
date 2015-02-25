<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Inventory extends Eloquent
{
	
	protected $table = 'inventory_receipts';
	public $timestamps = false;



public static function getCommodities()
	{
$commodities = DB::table('inventory_receipts')->select(DB::raw('id, commodity, batch_no, expiry_date, qty'))->lists('commodity', 'id');;

return $commodities;

	}
}