<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Metric extends Eloquent
{
	use SoftDeletingTrait;

	protected $table = 'metrics';
	protected $dates = ['deleted_at'];
}