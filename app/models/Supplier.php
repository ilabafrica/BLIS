<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Supplier extends Eloquent 
{
    use SoftDeletingTrait;
	protected $table = 'suppliers';
	protected $dates = ['deleted_at'];
	/**
	 * Stock relationship
	 */
	public function stocks()
	{
	  return $this->hasMany('Stock', 'supplier_id');
	}
}