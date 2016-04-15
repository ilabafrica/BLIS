<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Stock extends Eloquent 
{
	protected $table = 'inv_supply';
	/*
    *   Relationship with supplier
    */
    public function supplier()
    {
        return $this->belongsTo('Supplier');
    }
    /*
    *   Relationship with item
    */
    public function item()
    {
        return $this->belongsTo('Item');
    }
    /*
    *   Relationship with usage
    */
    public function usage()
    {
        return $this->hasMany('Usage');
    }
    /*
    *   Get quantity for the specific lot
    */
    public function quantity()
    {
    	$available = $this->quantity_supplied;
    	$used = $this->usage->sum('quantity_used');
    	return $available-$used;
    }
}