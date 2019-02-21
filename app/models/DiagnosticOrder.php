<?php



class DiagnosticOrder extends Eloquent
{
	protected $table = 'diagnostic_orders';
	public $fillable = ['test_id', 'diagnostic_order_status_id'];
	public $timestamps = false;
}
