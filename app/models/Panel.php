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
	public function testTypes()
    {
	    return $this->belongsToMany('TestType', 'test_type_panels');
	}
}
