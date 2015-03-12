<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Metric extends Eloquent
{
	protected $table = 'metrics';
	protected $dates = ['deleted_at'];
}