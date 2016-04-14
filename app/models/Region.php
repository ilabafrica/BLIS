<?php

class Region extends Eloquent
{
    protected $table = "regions";
   
    public function regionType()
    {
      return $this->belongsTo('RegionType', 'region_type_id');
    }
}
