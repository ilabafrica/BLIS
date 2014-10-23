<?php

class PrevalenceRatesReportController extends \BaseController {

	#Get months
	function __construct()
	{
		$from_date = Input::get('from');
		$to_date = Input::get('to');
		$this->months = Report::getMonths($from_date, $to_date);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		foreach ($this->months as $month) {
			$data = Report::prevalenceCounts($month);
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
		$from_date = Input::get('from');
		$to_date = Input::get('to');
		$months = Report::getMonths($from_date, $to_date);
		$test_types = TestType::select('test_types.id', 'test_types.name')
							->join('testtype_measures', 'test_types.id', '=', 'testtype_measures.test_type_id')
            				->join('measures', 'measures.id', '=', 'testtype_measures.measure_id')
            				->where('measure_range', 'LIKE', '%Positive/Negative%')
            				->get();

		$chart = '{id: "prevalences",type: "msline",
	      width: "98%",
	      height: "500px",
	      dataFormat: "json",
	      dataSource: {
	       "chart": {
	        "caption": "Prevalence Rates",
	        "subcaption": "For the selected period",
            "xaxisname": "Time",
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
	        "labelstep": "2",
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

	            	foreach ($months as $month) {
	    				$chart.= '{ "label": "'.$month->label." ".$month->annum.'" },';
		            }
	            $chart.=']
	        }
	    ],
	    "dataset": [';
        	foreach ($test_types as $test_type) {
        		$chart.= '{
        			"seriesname": "'.$test_type->name.'",
        			"data": [';
            		foreach ($months as $month) {
            			$data = Report::prevalenceCountsByTestType($month, $test_type->id);
            			foreach ($data as $datum) {
            				$chart.= '{ "value": "'.$datum->rate.'"},';
	            		}
	            		if($data->isEmpty())
            			{
            				$chart.= '{ "value": "0.00"},';
            			}
			    	}
		    	$chart.=']
		    	},';
		    }
           $chart.='
	    	]
	    }
	}';
	return $chart;
	}
	/**
	 * Function to filter prevalence rates by dates
	 */
	public static function filterByDate()
	{
		$from_date = Input::get('from');
		$to_date = Input::get('to');
		$months = Report::getMonths($from_date, $to_date);
		$data = '';
		foreach ($months as $month) {
			$data = Report::prevalenceCounts($month);
		}
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
