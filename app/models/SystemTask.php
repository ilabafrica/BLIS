<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SystemTask extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'system_tasks';
}