<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{
	
	protected $table = 'inventory_commodity';
	public $timestamps = false;

public function getCommodityIdbyName()
{
	return $this->hasMany('inventory_receipts');
	
}

}