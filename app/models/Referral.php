<?php

class Referral extends Eloquent 
{
    
    protected $table = 'referrals';
    public $timestamps = true;

    const REFERRED_IN = 0;
    const REFERRED_OUT = 1;

}