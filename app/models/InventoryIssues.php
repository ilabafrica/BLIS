<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryIssues extends Eloquent
{
	
	protected $table = 'inventory_issues';
	public $timestamps = false;


public function getTotalIssues()
	{
     $totalIssues = DB::table('inventory_issues')->sum('qty_req');
	}

}