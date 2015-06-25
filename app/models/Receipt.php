<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Receipt extends Eloquent
{
	use SoftDeletingTrait;
	protected $table = 'receipts';

	public function getTotalReceipts()
	{
		$totalReceipts = DB::table('receipts')->sum('qty');
	}

	/**
	* Commodities relationship
	*/
	public function commodity()
	{
		return $this->belongsTo('Commodity');
	}

	/**
	* Supplier relationship
	*/
	public function supplier()
	{
		return $this->belongsTo('Supplier');
	}

	/**
	* User relationship
	*/
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public static function getIssuedCommodities($from, $to){

	//$params = array($from, $to);
		$reportData = DB::select("SELECT *
			FROM receipts
			CROSS JOIN issues"
	//,
		//$params

		); 
		return $reportData;



	}

}