<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usage extends Model {

	protected $table = 'inv_usage';
	/*
    *   Relationship with stock
    */
    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }
}
