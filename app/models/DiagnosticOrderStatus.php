<?php



use Illuminate\Database\Eloquent\Model;

class DiagnosticOrderStatus extends Model
{
    const result_pending = 1;
    const result_sent = 2;
    public $timestamps = false;
}
