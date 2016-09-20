<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model {

	protected $table = 'inv_supply';
	/*
    *   Relationship with supplier
    */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
    /*
    *   Relationship with item
    */
    public function item()
    {
        return $this->belongsTo('App\Models\Item');
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
        $used = 0;
        $available = $this->quantity_supplied;
        if(count($this->usage)>0)
           $used = $this->usage->sum('quantity_used');
        return $available-$used;
    }
}
