<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Issues extends Eloquent
{
	
	protected $table = 'issues';

	public function getTotalIssues()
	{
		$totalIssues = DB::table('issues')->sum('qty_req');
	}

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('Commodity', 'id');
	}
}