<?php

class RegionType extends Eloquent
{
    protected $table = "region_types";
    public function tiers()
    {
      return $this->hasMany('RegionTypeTier', 'tier_id');
    }
}