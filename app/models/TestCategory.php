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
	 * Validation rules for test categories
	 *
	 */
	public static $rules = array('name' => 'required|unique:test_categories,name');

	/**
	 * Test types relationship
	 *
	 */
	public function testTypes(){
         return $this->hasMany('TestType', 'section_id');
      }
}