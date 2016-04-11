<?php

class Facility extends Eloquent
{
	protected $table = "facilities";

	public function county()
    {
      return $this->belongsTo('County', 'county_id');
    }
}