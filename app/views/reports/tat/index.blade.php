@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.turnaround-time') }}</li>
	</ol>
</div>
<div class="container-fluid">
	{{ Form::open(array('route' => array('reports.aggregate.tat'), 'id' => 'turnaround', 'class' => 'form-inline')) }}
	  	<div class="row">
			<div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
						{{ Form::label('start', trans("messages.from")) }}
					</div>
					<div class="col-sm-3">
						{{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-01'), 
					        array('class' => 'form-control standard-datepicker')) }}
				    </div>
		    	</div>
		    </div>
		    <div class="col-sm-5">
		    	<div class="row">
					<div class="col-sm-2">
				    	{{ Form::label('end', trans("messages.to")) }}
				    </div>
					<div class="col-sm-3">
					    {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
					        array('class' => 'form-control standard-datepicker')) }}
			        </div>
		    	</div>
		    </div>
		    <div class="col-sm-2">
			    {{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			        array('class' => 'btn btn-info loader-gif', 'id' => 'filter', 'type' => 'submit')) }}
		    </div>
		</div>
		<div class="row spacer">
			<div class="col-sm-4">
		    	<div class="row">
					<div class="col-sm-2">
						{{ Form::label('description',  Lang::choice('messages.test-category', 2)) }}
					</div>
					<div class="col-sm-2">
						{{ Form::select('section_id', array(''=>trans('messages.select-lab-section'))+$labSections, 
							    		Request::old('testCategory') ? Request::old('testCategory') : $testCategory, 
											array('class' => 'form-control', 'id' => 'section_id')) }}
				    </div>
		    	</div>
		    </div>
		    <div class="col-sm-4">
		    	<div class="row">
					<div class="col-sm-2">
				    	{{ Form::label('description', Lang::choice('messages.test-type', 1)) }}
				    </div>
					<div class="col-sm-2">
					    {{ Form::select('test_type', array('' => trans('messages.select-test-type'))+$testTypes, 
							    		Request::old('testType') ? Request::old('testType') : $testType, 
											array('class' => 'form-control', 'id' => 'test_type')) }}
			        </div>
		    	</div>
		    </div>
		    <div class="col-sm-4">
			    <div class="row">
					<div class="col-sm-2">
				    	{{ Form::label('label', trans("messages.interval")) }}
				    </div>
					<div class="col-sm-2">
					    {{ Form::select('period', array('' => trans('messages.select-interval'), 'M'=>trans('messages.monthly'), 'W'=>trans('messages.weekly'), 'D'=>trans('messages.daily')),
					    	Request::old('interval') ? Request::old('interval') : $interval,  
							array('class' => 'form-control', 'id'=>'period')) }}
			        </div>
		    	</div>
		    </div>
		</div>
	{{ Form::close() }}
</div>
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.turnaround-time') }}
	</div>
	<div class="panel-body">
		<!-- if there are filter errors, they will show here -->
		@if ($error)
			<div class="alert alert-info">{{ $error }}</div>
		@else
		<div id="trendsDiv">
			<?php $continue = 1; ?>
			@if(count($resultset)==0)
				<?php $continue = 0; ?>
				<table class="table-responsive">
					<tr>
						<td>{{ trans("messages.no-records-found") }}</td>
					</tr>
				</table>
			@endif
		</div>
		@endif
	</div>
</div>
<!-- Begin HighCharts scripts -->
{{ HTML::script('highcharts/highcharts.js') }}
{{ HTML::script('highcharts/exporting.js') }}
<!-- End HighCharts scripts -->
<?php
	$stat_list = array();
		$show_in_hours = true;
		$stat_list = $resultset;
		ksort($stat_list);
		$stat_lists[] = $stat_list;
		$testETAT = 0; //Test Estimated TAT
	$progressData = array();
	$waitingTimeData = array();

	foreach($stat_lists as $stat_list) {
		foreach($stat_list as $key => $value) {
			$displayDate = bcmul($key,1000);
			$waitValue = round($value[1],2);
			$TATValue = round($value[0],2);
			$testETAT = $value[2];

			if (!$show_in_hours) {	// Show in days.
				$waitValue = $waitValue/24;
				$TATValue = $TATValue/24;
				$testETAT = $testETA/24;
			}
			$progressData[] = array($displayDate, $TATValue);
			$waitingTimeData[] = array($displayDate, $waitValue);
		}
		$progressTrendsData[] = $progressData;
		$progressTrendsData[] = $waitingTimeData;
		unset($progressData);
	}

	# Build chart with time series
	?>
	<script type='text/javascript'>
		var progressTrendsData = new Array();
		var expectedTAT = new Array;
		var namesArray = new Array(<?php echo '"'.trans("messages.expected-tat").'","'.trans("messages.actual-tat").'","'.trans("messages.waiting-time").'"'; ?>);
		var progressTrendsDataTemp = <?php echo json_encode($progressTrendsData); ?>;

		var values, value1, value2;
		/* Convert the string timestamps to floatvalue timestamps */
		if(progressTrendsDataTemp[0].length != 0){
		for(var j=0;j<progressTrendsDataTemp.length;j++) {
			var i = 0;
			if( progressTrendsDataTemp[j][i]) {
				progressTrendsData[j] = new Array();
				while ( progressTrendsDataTemp[j][i] ) {
					values = progressTrendsDataTemp[j][i];
					value1 = parseFloat(values[0]);
					value2 = values[1];
					progressTrendsData[j][i] = [value1, value2];
					i++;
				}
			}
		}
		
		for(var i=0;i<progressTrendsData[0].length;i++) {
			tmp = (progressTrendsData[0][i]);
			expectedTAT[i] = [tmp[0], <?php echo $testETAT; ?>];
		}

		var options = {
		chart: {
			 renderTo: 'trendsDiv',
			 type: 'spline'
		  },
		  title: {
			 text: <?php echo '"'.trans("messages.turnaround-time").'"'; ?>//'TurnAroundTime Rate'
		  },
		  subtitle: {
		        text: <?php 
		        			$subtitle = '';
		        			$from = isset($input['start'])?$input['start']:date('d-m-Y');
							$to = isset($input['end'])?$input['end']:date('d-m-Y');
							if($from!=$to)
								$subtitle = trans("messages.from").' '.$from.' '.trans("messages.to").' '.$to;
							else
								$subtitle = trans("messages.for").' '.date('Y');
							if($interval=='M')
								$subtitle.= ' ('.trans("messages.monthly").') ';
							else if($interval=='D')
								$subtitle.= ' ('.trans("messages.Daily").') ';
							else 
								$subtitle.= ' ('.trans("messages.weekly").') ';

							if($testCategory)
								$subtitle.= ' - '.TestCategory::find($testCategory)->name;
							if($testType)
								$subtitle.= '('.TestType::find($testType)->name.')';
							echo '"'.$subtitle.'"';
						?>
		   },
		  credits: {
		        enabled: 'false'
		  },
		  xAxis: {
			 type: 'datetime',
			 dateTimeLabelFormats: { 
				month: '%e. %b',
				year: '%b'
			 },
		  },
		  yAxis: {
			 title: {
				text: <?php echo "'Time Taken (" . ($show_in_hours?'Hours':'Days') . ")'"; ?>
			 },
		  },
		  tooltip: {
			 formatter: function() {
			 	dhVal = parseInt(<?php echo ($show_in_hours)?"1":"24"; ?>);
			 	tVal = this.y * dhVal;
			 	hrs = Math.floor(tVal);
			 	mins = Math.round((tVal - hrs)*60);
			 	yshow = "";
			 	if(hrs < 1){
			 		yshow = mins + " Minutes";
			 	}else if(mins == 0){
			 		yshow = hrs + " Hours";
			 	}else{
			 		yshow = hrs + " Hours " + mins + " Minutes";
			 	}
			   return '<b>'+ this.series.name +'</b><br/>' + Highcharts.dateFormat('%e. %b', this.x) +': '+ yshow;
			 }
		  },
		  series: []
	   };

		progressTrendsData.unshift(expectedTAT);
		
		for(var i=0;i<namesArray.length;i++) {
			if (progressTrendsData[i].length > 0) {
				options.series.push({
					name: namesArray[i],
					data: progressTrendsData[i]
				});
			}
		}
		Highcharts.setOptions({
		    global: {
		        useUTC: false
		    }
		});
		new Highcharts.Chart(options);
	}
		
	</script>
@stop