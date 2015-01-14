<?php

class Referral extends Eloquent 
{
    
    protected $table = 'referrals';
    public $timestamps = true;

    const REFERRED_IN = 0;
    const REFERRED_OUT = 1;

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function facility()
    {
    	return $this->belongsTo('Facility');
    }

}