<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TestCategory extends Eloquent
{
	/**
	 * Enabling soft deletes for test categories.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_categories';

	/**
	 * Test types relationship
	 *
	 */
	public function testTypes(){
         return $this->hasMany('TestType', 'test_category_id');
      }
}