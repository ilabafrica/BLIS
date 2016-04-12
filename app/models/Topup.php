<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Topup extends Eloquent 
{
    use SoftDeletingTrait;
	protected $table = 'requests';
	protected $dates = ['deleted_at'];
	/**
	 * Test category relationship
	 */
	public function testCategory()
	{
		return $this->belongsTo('TestCategory');
	}
	/**
	 * Item relationship
	 */
	public function item()
	{
		return $this->belongsTo('Item');
	}

	/**
	 * Usage relationship
	 */
	public function usage()
	{
		return $this->hasMany('Usage', 'request_id');
	}
	/**
	 * Quantity issued
	 */
	public function issued()
	{
		return $this->usage->sum('quantity_used');
	}
}