<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'inv_items';
    /*
    *   Relationship with stocks
    */
    public function stocks()
    {
        return $this->hasMany('App\Models\Stock', 'item_id');
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