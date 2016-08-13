<?php

class RegionTypeTier extends Eloquent
{
    protected $table = "region_type_tiers";

    public function regionType()
    {
      return $this->belongsTo('RegionType', 'region_type_id');
    }

    public function tier()
    {
      return $this->belongsTo('RegionType', 'tier_id');
    }


}