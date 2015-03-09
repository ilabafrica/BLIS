<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{

	protected $table = 'commodities';

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

	public function metric()
	{
		return $this->belongsTo('Metric', 'id');
	}
}