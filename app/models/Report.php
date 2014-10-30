<?php
class Report{
	/*
	*	Begin prevalence rates functions
	*/
	/**
	* Load months: Load time period in months when filter dates are not set
	*/
	public static function loadMonths($year){
		$months = Test::select(DB::raw('MIN(time_created) as start, MAX(time_created) as end'))
							->whereRaw('YEAR(time_created) = '.$year)
							->get();
		return $months;
	}
	#	End function to load months

	/**
	* Get months: return months for time_created column when filter dates are set
	*/	
	public static function getMonths($from, $to){
		$dates = Test::select(DB::raw('DISTINCT MONTH(time_created) as months, LEFT(MONTHNAME(time_created), 3) as label, YEAR(time_created) as annum'));
		if($from==$to){
			$year = date('Y');
			$dates->whereRaw('YEAR(time_created) = '.$year);
		}
		else{
			$dates->whereBetween('time_created', array($from, $to));
			}
		return $dates->orderBy('time_created', 'ASC')->get();
	}
}