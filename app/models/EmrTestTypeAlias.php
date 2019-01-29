<?php

class EmrTestTypeAlias extends Eloquent{
    protected $table = 'emr_test_type_aliases';

    public $timestamps = false;

    public function TestType()
    {
        return $this->belongsTo('TestType', 'test_type_id', 'id');
    }

    public function MH4Mapper()
    {
        return $this->belongsTo('MH4Mapper', 'emr_alias', 'data_element_id');
    }
}
