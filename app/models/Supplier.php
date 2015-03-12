<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Supplier extends Eloquent {

	protected $table = 'suppliers';
	protected $dates = ['deleted_at'];

}