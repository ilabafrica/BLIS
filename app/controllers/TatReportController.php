<?php

class TatReportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tat = self::overallTAT();
		$test_types = TestType::all();
		$labsections = TestCategory::lists('name', 'id');
		return View::make('reports.tat.index')
					->with('labsections', $labsections)
					->with('test_types', $test_types)
					->with('tat', $tat);
	}


	/**
	 * Function to return average target TAT.
	 *
	 * @return Response
	 */
	public static function overallTATByFilters($period, $labsection, $testtype, $interval)
	{
		$TaT = Test::select(DB::raw('SUM(targetTAT)/COUNT(test_types.id) as target, 
						SUM(TIMESTAMPDIFF(SECOND, tests.time_created, tests.time_started))/COUNT(tests.id) as waiting, 
						SUM(TIMESTAMPDIFF(SECOND, tests.time_started, tests.time_completed))/COUNT(tests.id) as tat'))
						->join('test_types', 'tests.test_type_id', '=', 'test_types.id');
		if($labsection){
			$TaT->where('section_id', '=', $labsection);
		}
		if($labsection&&$testtype){
			$TaT->where('section_id', '=', $labsection)
				->where('test_types.id', '=', $testtype);
		}
		if($interval=='M'){
			$TaT->whereRaw('MONTH(time_created) = '.$period->months)
				->whereRaw('YEAR(time_created) = '.$period->annum);
		}
		else if($interval=='W'){
			$TaT->whereRaw('WEEK(time_created) = '.$period->weekNumber)
				->whereRaw('YEAR(time_created) = '.$period->annum);
		}
		else if($interval=='D'){
			$TaT->whereRaw('DATE(time_created) LIKE \'%'.$period->label.'%\'');
		}
		return $TaT->get();
	}

	/**
	 * Function to return TAT.
	 *
	 * @return Response
	 */
	public function overallTAT()
	{
		$TaT = TestType::select(DB::raw('SUM(targetTAT)/COUNT(test_types.id) as target, 
						SUM(TIMESTAMPDIFF(SECOND, tests.time_created, tests.time_started))/COUNT(tests.id) as waiting, 
						SUM(TIMESTAMPDIFF(SECOND, tests.time_started, tests.time_completed))/COUNT(tests.id) as tat'))
						->join('tests', 'tests.test_type_id', '=', 'test_types.id')
						->get();
		return $TaT;
	}


	/**
	 * Function to return fusion chart
	 *
	 * @return Response
	 */
	public static function turnaroundtimeChart($from, $to, $section=null, $test=null, $interval='M'){
		$label=array('Target TAT', 'Waiting Time', 'Actual TAT');
		$variables=array('target', 'waiting', 'tat');
		$from = Input::get('start');
		$to = Input::get('end');
		$periods='';
		if($interval=='M'){
				$periods = Report::getMonths($from, $to);
		}
		else if($interval=='W'){
			$periods = Report::getWeeks($from, $to);
		}
		else if($interval=='D'){
			$periods = Report::getDays($from, $to);
		}
		
		$chart = '{
	       "chart": {
	        "caption": "Turnaround Time",
	        "subcaption": ';
	        if($from==$to)
	        	$chart.='"For the year '.date('Y').'",';
	        else
	        	$chart.='"From '.$from.' To '.$to.'",';
            $chart.='"xaxisname": ';
	        if($interval=='M')
	        	$chart.='"Monthly Periods",';
	        else if($interval=='W')
	        	$chart.='"Weekly Periods",';
	        else if($interval=='D')
	        	$chart.='"Daily Periods",';
            $chart.='"yaxisname": "Time Taken (Hours)",
	        "linethickness": "1",
	        "exportEnabled":"1",
	        "showvalues": "0",
	        "formatnumberscale": "0",
	        "numbersuffix": " Hours",
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
	        "legendborderalpha": "30",
	        "canvasborderalpha": "50",
	        "numvdivlines": "5",
	        "vdivlinealpha": "20",
	        "showborder": "1",
	        "anchorRadius": "3",
            "anchorBorderThickness": "2",
            "animation": "1",
            "paletteColors":"0080C0, 800080, FF8040"
	    },
	    "categories": [
	        {
	            "category": [';
	            	$count = count($periods);
	            	foreach ($periods as $period) {
	            		if($interval=='D')
	            			$period->annum='';
	    				$chart.= '{ "label": "'.$period->label." ".$period->annum;
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
	    	$counts=count($label)-1;
	    	for($i=0; $i<count($label); $i++) {
        		$chart.= '{
        			"seriesname": "'.$label[$i].'",
        			"data": [';
        				$counter = count($periods);
            			foreach ($periods as $period) {
            			$data = self::overallTATByFilters($period, $section, $test, $interval);
            			foreach ($data as $datum) {
            				$chart.= '{"value": "'.round($datum->$variables[$i]/3600, 2);
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
		    	if($counts==0)
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
	 * Filter TAT report
	 *
	 * @return Response
	 */
	public function filterTaT()
	{
		$from = Input::get('start');
		$to = Input::get('end');
		$section = Input::get('section_id');
		$test = Input::get('test_type');
		$interval = Input::get('interval');
		if($from||$to||$section||$test||$interval){
			$data = self::turnaroundtimeChart($from, $to, $section, $test, $interval);
		}
		return Response::json($data);
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
