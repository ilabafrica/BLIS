<?php

class County extends Eloquent
{
    protected $table = "counties";

    public function country()
    {
      return $this->belongsTo('Country', 'country_id');
    }
}
