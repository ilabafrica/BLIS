<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
    * Relationship between payment and the patient who handled it
    */
    public function patient(){
        return $this->belongsTo('App\Models\Patient');
    }
}
