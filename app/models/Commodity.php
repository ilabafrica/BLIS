<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{
	
	protected $table = 'inventory_commodity';
	public $timestamps = false;



}