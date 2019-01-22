<?php





class Gender extends Eloquent
{
    const male = 1;
    const female = 2;
    const both = 3;
    const unknown = 4;

    public $timestamps = false;

    public function Patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }

    public function MeasureRange()
    {
        return $this->belongsTo('App\Models\MeasureRange');
    }
}
