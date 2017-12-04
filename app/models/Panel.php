<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Panel extends Eloquent
{
	/**
	 * Enabling soft deletes for panel.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'panel';

	/**
	 * Test types relationship
	 *
	 */
	public function testType(){
         return $this->belongsToMany('TestType', 'Test_Type_Panels');
      }
    // public function testtypepanel(){
    // 	return $this->hasMany('TestTypePanel');
    // }	
}
