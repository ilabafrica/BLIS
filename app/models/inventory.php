<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class inventory extends Eloquent
{
	
	protected $table = 'inventory_receipts';
	public $timestamps = false;

}