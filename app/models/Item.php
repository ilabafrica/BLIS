<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Item extends Eloquent
{
	/**
	 * Enabling soft deletes for drugs.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'inv_items';
	/*
    *   Relationship with stocks
    */
    public function stocks()
    {
        return $this->hasMany('Stock');
    }

    /*
    *   Relationship with requests
    */
    public function requests()
    {
        return $this->hasMany('Topup');
    }
    /*
    *   Get quantity for the specific item
    */
    public function quantity()
    {
        $available = $this->stocks->sum('quantity_supplied');
        $used = Usage::whereIn('stock_id', $this->stocks->lists('id'))->sum('quantity_used');
        return $available-$used;
    }
}