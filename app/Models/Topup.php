<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topup extends Model 
{
    use SoftDeletes;
	protected $table = 'requests';
	protected $dates = ['deleted_at'];
	/**
	 * Test category relationship
	 */
	public function testCategory()
	{
		return $this->belongsTo('App\Models\TestCategory');
	}
	/**
	 * Item relationship
	 */
	public function item()
	{
		return $this->belongsTo('App\Models\Item');
	}

	/**
	 * Usage relationship
	 */
	public function usage()
	{
		return $this->hasMany('App\Models\Usage', 'request_id');
	}
	/**
	 * Quantity issued
	 */
	public function issued()
	{
		return $this->usage->sum('quantity_used');
	}
	/**
	 * User relationship
	 */
	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}