<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class AuditResult extends Eloquent
{
	use SoftDeletingTrait;
	protected $table = 'audit_results';
	protected $dates = ['deleted_at'];

}