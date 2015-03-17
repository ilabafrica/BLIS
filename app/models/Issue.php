<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Issue extends Eloquent
{
	use SoftDeletingTrait;
	protected $table = 'issues';
	protected $dates = ['deleted_at'];

	public function getTotalIssues()
	{
		$totalIssues = DB::table('issues')->sum('qty_req');
	}

	/**
	* Topup request relationship
	*/
	public function topupRequest()
	{
		return $this->belongsTo('TopupRequest');
	}

	/**
	* Relationship between commodity and the user who was issued 
	* the items
	*/
	public function receiver(){
		return $this->belongsTo('user', 'issued_to');
	}

	/**
	* User relationship
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	* Receipts relationship
	*/
	public function receipt()
	{
		return $this->belongsTo('Receipt');
	}
}