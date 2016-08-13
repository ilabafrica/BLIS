<?php

class RegionTier extends Eloquent
{
    protected $table = "region_tiers";

    public function region()
    {
      return $this->belongsTo('Region', 'region_id');
    }

    public function tier()
    {
      return $this->belongsTo('Region', 'tier_id');
    }
}