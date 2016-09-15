<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
    * Relationship between charge and test
    */
    public function test()
    {
        return $this->hasMany('App\Models\Test');
    }

}
