<?php

class PrevalenceRatesReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$year = date('Y');
		$periods = Report::loadMonths($year);
		foreach ($periods as $period) {
			$data = self::prevalenceCounts($period->start, $period->end);
		}
		return View::make('reports.prevalence.index')
					->with('data', $data);
	}
	/**
	 * Display prevalence rates chart
	 *
	 * @return Response
	 */
	public static function prevalenceRatesChart(){
		$from = Input::get('start');
		$to = Input::get('end');
		$months = Report::getMonths($from, $to);
		$test_types = TestType::select('test_types.id', 'test_types.name')
							->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
            				->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
            				->where('measure_range', 'LIKE', '%Positive/Negative%')
            				->get();

		$chart = '{
	       "chart": {
	        "caption": "Prevalence Rates",
	        "subcaption": ';
	        if($from==$to)
	        	$chart.='"For the year '.date('Y').'",';
	        else
	        	$chart.='"From '.$from.' To '.$to.'",';
            $chart.='"xaxisname": "Time",
            "yaxisname": "Prevalence Rates (In %)",
	        "linethickness": "1",
	        "exportEnabled":"1",
	        "showvalues": "0",
	        "formatnumberscale": "0",
	        "numbersuffix": "%",
	        "anchorradius": "2",
	        "divlinecolor": "666666",
	        "divlinealpha": "30",
	        "divlineisdashed": "1",
	        "labelstep": "1",
	        "bgcolor": "FFFFFF",
	        "showalternatehgridcolor": "0",
	        "labelpadding": "10",
	        "canvasborderthickness": "1",
	        "legendiconscale": "1.5",
	        "legendshadow": "0",
	        "legendborderalpha": "0",
	        "canvasborderalpha": "50",
	        "numvdivlines": "5",
	        "vdivlinealpha": "20",
	        "showborder": "1",
	        "anchorRadius": "6",
            "anchorBorderThickness": "2",
            "yAxisMinValue": "0",
            "yAxisMaxValue": "100"
	    },
	    "categories": [
	        {
	            "category": [';
	            	$count = count($months);
	            	foreach ($months as $month) {
	    				$chart.= '{ "label": "'.$month->label." ".$month->annum;
	    				if($count==1)
	    					$chart.='" }';
	    				else
	    					$chart.='" },';
	    				$count--;
		            }
	            $chart.=']
	        }
	    ],
	    "dataset": [';
	    	$counts = count($test_types);
	    	foreach ($test_types as $test_type) {
        		$chart.= '{
        			"seriesname": "'.$test_type->name.'",
        			"data": [';
        				$counter = count($months);
            			foreach ($months as $month) {
            			$data = self::prevalenceCountsByTestType($month, $test_type->id);
            			foreach ($data as $datum) {
            				$chart.= '{"value": "'.$datum->rate;
            				if($counter==1)
            					$chart.='"}';
            				else
            					$chart.='"},';
	            		}

	            		if($data->isEmpty())
            			{
            				$chart.= '{ "value": "0.00';
            				if($counter==1)
            					$chart.='"}';
            				else
            					$chart.='"},';
            			}
            			$counter--;
			    	}
		    	$chart.=']';
		    	if($counts==1)
					$chart.='}';
				else
					$chart.='},';
				$counts--;
		    }
           $chart.='
	    	]
	    }';
	return $chart;
	}
	/**
	 * Function to filter prevalence rates by dates
	 */
	public static function filterByDate()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		
		$months = Report::getMonths($from, $to);
		$data = self::prevalenceCounts($from, $to);
		$chart = self::prevalenceRatesChart();
		return Response::json(array('values'=>$data, 'chart'=>$chart));
		//array('values'=>$data, 'chart'=>$chart)
	}

	#Begin function to return test_type_id, test_type_name, total specimen tested, positive and negative counts
	public static function prevalenceCounts($from, $to){
		$data =  Test::select(DB::raw('test_types.id as id, test_types.name as test, count(tests.specimen_id) as total, 
					SUM(IF(test_results.result=\'Positive\',1,0)) positive, SUM(IF(test_results.result=\'Negative\',1,0)) negative,
					ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'))
					->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
					->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
					->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
					->join('test_results', 'tests.id', '=', 'test_results.test_id')
					->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
					->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
					->whereBetween('time_created', array($from, $to))
					->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
					->groupBy('test_types.id')
					->get();
		return $data;
	}
	#End function to return counts

	#	Begin function to return counts by month and test type
	public static function prevalenceCountsByTestType($month, $test_type){
		$data =  Test::select(DB::raw('ROUND( SUM( IF( test_results.result =  \'Positive\', 1, 0 ) ) *100 / COUNT( tests.specimen_id ) , 2 ) AS rate'))
					->join('test_types', 'tests.test_type_id', '=', 'test_types.id')
					->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
					->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
					->join('test_results', 'tests.id', '=', 'test_results.test_id')
					->join('measure_types', 'measure_types.id', '=', 'measures.measure_type_id')
					->where('measures.measure_range', 'LIKE', '%Positive/Negative%')
					->where('test_types.id', '=', $test_type)
					->whereRaw('MONTH(time_created) = '.$month->months)
					->whereRaw('YEAR(time_created) = '.$month->annum)
					->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
					->groupBy('test_types.id')
					->get();
		return $data;
	}
	#	End function to return counts by month and test type

}
