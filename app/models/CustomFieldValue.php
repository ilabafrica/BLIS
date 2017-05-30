<?php

class CustomFieldValue extends Eloquent
{
    protected $table = 'custom_field_values';

    public function customField()
    {
        return $this->belongsTo('CustomField');
    }
}