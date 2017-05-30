<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class CustomField extends Eloquent
{
	use SoftDeletingTrait;
	
	protected $table = "custom_fields";

	public function customfieldtype()
	{
		return $this->belongsTo('CustomFieldType');
	}
}