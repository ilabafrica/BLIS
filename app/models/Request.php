<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Request extends Eloquent 
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
}