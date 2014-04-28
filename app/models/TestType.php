
<?php

class TestType extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'test_type';

	/**
	 * Enabling soft deletes for specimen type details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;
}