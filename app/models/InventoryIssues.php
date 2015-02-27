<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryIssues extends Eloquent
{
	
	protected $table = 'inventory_issues';
	public $timestamps = false;


public function QtyIssued()
{
 return $this->belongsToMany('qty_req');
}

}