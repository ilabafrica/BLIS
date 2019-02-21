<?php

class EmrResultAlias extends Eloquent
{
	protected $table = 'emr_result_aliases';
	public $fillable = ['emr_test_type_alias_id', 'measure_range_id'];

	public $timestamps = false;
}