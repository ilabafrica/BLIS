<?php

class TestTypeCategory extends Eloquent
{
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function testTypes()
    {
        return $this->hasMany('App\Models\TestType');
    }
}