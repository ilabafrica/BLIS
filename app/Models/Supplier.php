<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model {
    use SoftDeletes;
	protected $table = 'suppliers';
	protected $dates = ['deleted_at'];

	/**
	 * Stock relationship
	 */
	public function stocks()
	{
	  return $this->hasMany('App\Models\Stock', 'supplier_id');
	}

}