<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model 
{
    
    protected $table = 'referrals';
    public $timestamps = true;

    const REFERRED_IN = 0;
    const REFERRED_OUT = 1;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function facility()
    {
    	return $this->belongsTo('App\Models\Facility');
    }

}