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
			$data = Report::prevalenceCounts($period->start, $period->end);
		}
		return View::make('reports.prevalence.index')
					->with('data', $data);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

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
            "anchorBorderThickness": "2"
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
            			$data = Report::prevalenceCountsByTestType($month, $test_type->id);
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
		$data = Report::prevalenceCounts($from, $to);
		$chart = self::prevalenceRatesChart();
		return Response::json(array('values'=>$data, 'chart'=>$chart));
		//array('values'=>$data, 'chart'=>$chart)
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
