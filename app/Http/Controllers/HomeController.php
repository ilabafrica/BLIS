<?php namespace App\Http\Controllers;
set_time_limit(0);

use App\Models\Test;
use DB;
use Auth;
use DateTime;
use Jenssegers\Date\Date as Carbon;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get test stuses in an array
		$statuses = [Test::PENDING => 'Pending', Test::STARTED => 'Started', Test::COMPLETED => 'Completed', Test::VERIFIED => 'Verified'];
		//	Fetch hours of the day - 24hrs
		$today = Carbon::today();
		$today = Carbon::parse('2016-01-26');
		$leo = clone $today;
		$tomorrow =  Carbon::parse('2016-01-26')->addDay();
		$hours = [];
		while($today->lt($tomorrow))
		{
			$hours[] = $today->hour.':'.$today->minute.$today->minute;
			$today = $today->addHour();
		}
		$chart = "{
			chart:{
				renderTo: 'chart'
			},
	        title: {
	            text: 'Daily Tests per Status',
	            x: -20 //center
	        },
	        xAxis: {
	            categories: [";
	            $count = count($hours);
            	foreach ($hours as $hour)
            	{
    				$chart.= "'".$hour;
    				if($count==1)
    					$chart.="' ";
    				else
    					$chart.="' ,";
    				$count--;
    			}
	            $chart.="],
	            labels: {
	            	step: 2
	            }
	        },
	        yAxis: {
	        	min: 0,
	            title: {
	                text: 'Number of Tests'
	            }
	        },
	        legend: {
	            enabled: true,
	            align: 'center',
	            verticalAlign: 'bottom',
	            y: 0,
	            padding: 0,
	            margin:5,
	            itemMarginTop: 0,
	            itemMarginBottom: 0,
	            itemStyle:{
	                fontSize: '10px'
	                }
	        },
	        credits: {
			    enabled: false
			},
			colors: ['#C0392B', '#F1C40F', '#3498DB', '#2C3E50'],
	        series: [";
	        	$counts = count($statuses);
	        	foreach ($statuses as $key => $value)
	        	{
	        		$counter = count($hours);
	        		$chart.="{name:"."'".$value."'".", data:[";
	        		$to = clone $leo;
		        	foreach ($hours as $hour)
		        	{
		        		$data = Test::perHour($key, $to);
			        	$chart.= $data;
        				if($counter==1)
        					$chart.="";
        				else
        					$chart.=",";
	        			$counter--;
	        			$to = $to->addHour();
	        		}
	        		$chart.="]";
	            	if($counts==1)
						$chart.="}";
					else
						$chart.="},";
					$counts--;
		        }
		    $chart.="
	        ]
	    }";
		$tests = Test::orderBy('id', 'desc')->take(5)->get();
		return view('dashboard', compact('chart', 'tests'));
	}
}
