<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

	protected $table = 'inv_supply';
	/*
    *   Relationship with supplier
    */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }
    /*
    *   Relationship with item
    */
    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
    /*
    *   Relationship with usage
    */
    public function usage()
    {
        return $this->hasMany('App\Models\Usage');
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
