@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ Lang::choice('messages.quality-control', 2) }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.qualityControl'), 'id' => 'qc', 'method' => 'post')) }}
<div class="container-fluid">
  	<div class="row report-filter">
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('start_date', trans("messages.from")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('end_date', trans("messages.to")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-4">
	        <div class="col-md-3">
	        	{{ Form::label('control', Lang::choice('messages.control',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('control', array(null => '')+ $control->lists('name', 'id'),
	            	isset($input['control'])?$input['control']:0, array('class' => 'form-control')) }}
	        </div>
        </div>
        <div class="col-md-2">
        	{{Form::submit(trans('messages.view'), 
	        	array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
        </div>
  	</div>
</div>
{{ Form::close() }}
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.controlresults') }}
	</div>

	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
	@include("reportHeader")
	</div>
		<div id="test_records_div">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>{{ trans('messages.date-performed')}}</th>
						<th>{{ trans('messages.lot-number')}}</th>
						<th>{{ trans('messages.performed-by')}}</th>
						@foreach($control->controlMeasures as $controlMeasure)
							<th> {{ $controlMeasure->name . ' ('. $controlMeasure->controlMeasureRanges->first()->getRangeUnit() . ')' }} </th>
						@endforeach
					</tr>
					@forelse($controlTests as $key => $controlTest)
						<tr>
							<td>{{ $controlTest->created_at }} </td>
							<td>{{ $controlTest->lot->lot_no }} </td>
							<td>{{ $controlTest->performed_by }} </td>
							@foreach($controlTest->controlResults as $controlResult)
								<td>{{ $controlResult->results}}</td>
							@endforeach
						</tr>
					@empty
						<p>No results found for the specified date.</p>
					@endforelse
				</tbody>
			</table>
			<div id="leveyjennings"></div>
		</div>
</div>
<!-- Begin HighCharts scripts -->
{{ HTML::script('highcharts/highcharts.js') }}
{{ HTML::script('highcharts/exporting.js') }}
<!-- End HighCharts scripts -->
<script type="text/javascript">
$( document ).ready(function() {
	var chartdatam = {{ $leveyJennings }}
	console.log(chartdatam);
	$.each(chartdatam , function(key, chartdata){
		var chartdivid = 'chart_'+key;
		var chartdiv = '<div id="'+chartdivid+'"></div>';
		$('#leveyjennings').append(chartdiv);
		if(chartdata.success == true){
			createLJChart(chartdata, chartdivid);
		}
	});
});

function createLJChart(chartdata, chartdivid){
	$('#'+chartdivid).highcharts({
		title: {
			text: 'Levey Jennings chart',
			x: -20 //center
		},
		subtitle: {
			text: 'For control '+chartdata.controlName,
			x: -20
		},
		xAxis: {
			categories: chartdata.dates
		},
		yAxis: {
			title: {
				text: 'Control results '.concat(chartdata.controlUnit) 
			},
			max: chartdata.average + (chartdata.standardDeviation * 3),
			min: chartdata.average - (chartdata.standardDeviation * 3),
			plotLines: [{
				// +1s
			color: 'red',
			dashStyle: 'Dash',
			width: 1,
			label: {
				text: '+3 SD ('+ chartdata.plusthreesd +')',
				align: "right",
				style: {
					fontSize: 12,
					color: '#606060'
				},
			},
				value: chartdata.plusthreesd
			},{
				// +1s
				color: 'brown',
				dashStyle: 'longdashdot',
				width: 1,
				label: {
					text: '+2 SD ('+ chartdata.plustwosd +')',
					align: "right",
					style: {
						fontSize: 12,
						color: '#606060'
					},
				},
				value: chartdata.plustwosd
			},{
				// +1s
				color: 'blue',
				dashStyle: 'longdashdot',
				width: 1,
				label: {
					text: '+1 SD ('+ chartdata.plusonesd +')',
					align: "right",
					style: {
						fontSize: 12,
						color: '#606060'
					},
				},
				value: chartdata.plusonesd
			},
			{
				// Average
				color: 'green',
				width: 1,
				label: {
					text: 'Mean ('+chartdata.average+ ')',
					align: "right",
					style: {
						fontSize: 12,
						color: '#606060'
					},
				},
				value: chartdata.average,// Need to set this probably as a var.
			},
			{
				// -1sd
				color: 'blue',
				dashStyle: 'longdashdot',
				width: 1,
				value: chartdata.minusonesd,// Need to set this probably as a var.
				label: {
					text: '-1 SD ('+ chartdata.minusonesd +')',
					align: "right",
					style: {
						fontSize: 12,
						color: '#606060'
					},
				}
			},
			{
				// -2sd
				color: 'brown',
				dashStyle: 'longdashdot',
				width: 1,
				value: chartdata.minustwosd ,// Need to set this probably as a var.
				label: {
					text: '-2 SD ('+ chartdata.minustwosd +')',
					align: "right", 
					style: {
						fontSize: 12,
						color: '#606060'
					},
				}
			},
			{
				// -3sd
				color: 'red',
				dashStyle: 'Dash',
				width: 1,
				value: chartdata.minusthreesd,// Need to set this probably as a var.
				label: {
					text: '-3 SD ('+ chartdata.minustwosd +')',
					align: "right",
					style: {
						fontSize: 12,
						color: '#606060'
					},
				}
			}
			]
        },
        tooltip: {
            valueSuffix: ' '+chartdata.controlUnit 
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: chartdata.controlName,
            data: chartdata.results
        }],
    });
}
</script>
@stop