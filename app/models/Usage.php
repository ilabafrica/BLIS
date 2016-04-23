<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Usage extends Eloquent 
{
	protected $table = 'inv_usage';
	/*
    *   Relationship with stock
    */
    public function stock()
    {
        return $this->belongsTo('Stock');
    }
    /*
    *   Relationship with request
    */
    public function request()
    {
        return $this->belongsTo('Topup');
    }
}