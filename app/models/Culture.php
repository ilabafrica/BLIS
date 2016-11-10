<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Culture extends Eloquent
{
	/**
	 * Enabling soft deletes for culture.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'culture_worksheet';
	/**
	 * User relationship
	 */
	public function user()
	{
	  return $this->belongsTo('User', 'user_id');
	}
	/**
	 * Test relationship
	 */
	public function test()
    {
        return $this->hasOne('Test', 'test_id');
    }
    /*Get well formatted dates*/
	public static function showTimeAgo($date)
	{
		if(empty($date))
		{
			return "No date provided";
		}
    
		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths = array("60","60","24","7","4.35","12","10");
    
		$now = time();
		$unix_date = strtotime($date);
    
		// check validity of date
		if(empty($unix_date))
		{  
			return "Bad date";
		}
 
		// is it future date or past date
		if($now > $unix_date) 
		{  
			$difference     = $now - $unix_date;
			$tense         = "ago";
		} 
		else 
		{
			$difference     = $unix_date - $now;
			$tense         = "ago";
		}
    
		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) 
		{
			$difference /= $lengths[$j];
		}
    
		$difference = round($difference);
		
		if($difference != 1) 
		{
			$periods[$j].= "s";
		}
    
		return "$difference $periods[$j] {$tense}";
	}
}