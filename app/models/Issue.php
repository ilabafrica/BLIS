<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Issue extends Eloquent
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
		return $this->belongsTo('Commodity');
	}

	/**
	* User relationship
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * TestCategory relationship
	 */
	public function section()
	{
		return $this->belongsTo('TestCategory', 'test_category_id');
	}

	/**
	* Receipts relationship
	*/
	public function receipt()
	{
		return $this->belongsTo('Receipt');
	}
}