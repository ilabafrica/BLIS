<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Supplier extends Eloquent {
    use SoftDeletingTrait;
	protected $table = 'suppliers';
	protected $dates = ['deleted_at'];

}