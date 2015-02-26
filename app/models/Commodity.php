<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{
	
	protected $table = 'inventory_commodities';
	public $timestamps = false;



}