<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model {

	protected $table = 'inv_usage';
	/*
    *   Relationship with stock
    */
    public function stock()
    {
        return $this->belongsTo('App\Models\Stock', 'stock_id');
    }
}
