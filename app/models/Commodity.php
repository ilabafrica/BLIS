<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{

	protected $table = 'commodities';
	protected $dates = ['deleted_at'];

	/**
	* Relationship between receipts and 
	*/
	public function receipts()
	{
		return $this->hasMany('Receipt');
	}

	/**
	* Relationship between commodity and the user who handled it
	*/
	public function user(){
		return $this->belongsTo('user');
	}

	/**
	* Relationship with metric
	*/
	public function metric()
	{
		return $this->belongsTo('Metric');
	}

	/**
	* Function to get the remaining comodities
	*/
	public function available()
	{
		//Total received - total issued
		$totalReceived = DB::table('receipts')->where('commodity_id', '=', $this->id)->sum('quantity');
		$totalIssued = DB::table('issues')->join('topup_requests', 'topup_request_id', '=', 'topup_requests.id')->sum('quantity_issued');

		return $totalReceived - $totalIssued;
	}
}