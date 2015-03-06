<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class InventoryIssues extends Eloquent
{
	
	protected $table = 'inventory_issues';

	public function getTotalIssues()
	{
		$totalIssues = DB::table('inventory_issues')->sum('qty_req');
	}

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('InventoryCommodity', 'id');
	}
}