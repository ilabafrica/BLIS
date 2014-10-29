@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.reports') }}</li>
	  <li class="active">{{ trans('messages.prevalence-rates-report') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.prevalence-rates-report') }}
	</div>
	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
	<div class="alert alert-danger" id="error" style="display:none;"></div>
	<div class="table-responsive">
	{{ Form::open(array('url' => 'tat/filter', 'id' => 'turnaround', 'method' => 'post')) }}
  <table class="table">
    <thead>
    <tr>
        <td>{{ Form::label('name', trans("messages.from")) }}</td>
        <td>{{ Form::text('start', Input::old('start'), array('class' => 'form-control', 'id' => 'start')) }}</td>
        <td>{{ Form::label('name', trans("messages.to")) }}</td>
        <td>{{ Form::text('end', Input::old('end'), array('class' => 'form-control', 'id' => 'end')) }}</td>
        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
			        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
  		<td>{{ Form::button("<span class='glyphicon glyphicon-remove'></span> ".trans('messages.close'), 
			        array('class' => 'btn btn-warning', 'style' => 'width:125px', 'id' => 'close')) }}</td>
    </tr>
    <tr>
        <td>{{ Form::label('description', trans("messages.test-category")) }}</td>
         <td>{{ Form::select('section_id', array(''=>trans("messages.select-lab-section"))+$labsections, Input::old('section_id'), 
					array('class' => 'form-control', 'id' => 'section_id')) }}</td>
         <td>{{ Form::label('test_type', trans("messages.test-type")) }}</td>
         <td>{{ Form::select('test_type', array('' => trans("messages.select-test-type")), Input::old('test_type'), 
					array('class' => 'form-control', 'id' => 'test_type')) }}</td>
         <td>{{ Form::label('interval', trans("messages.interval")) }}</td>
         <td>{{ Form::select('interval', array('M' => 'Monthly', 'W' => 'Weekly', 'D' => 'Daily'), Input::old('interval'), 
					array('class' => 'form-control', 'id'=>'interval')) }}</td>
     </tr>
</thead>
<tbody>
	
</tbody>
  </table>
  {{ Form::close() }}
  <div id="chartContainer"></div>
  <div id="chart"></div>
  <!-- THE TABLE DATA WILL GO HERE. TO BE HANDLED AFTER ALPHA RELEASE.
  <div id="dataDiv">
  	<table class="table">
		<tbody>
			<th>{{trans("messages.expected-tat")}}</th>
			<th>{{trans("messages.tests-in-interval")}}</th>
			<th>{{trans("messages.tests-exceeding-interval")}}</th>
			@forelse($tat as $time)
			<tr>
				<td colspan="3">{{ $time->target }}</td>
			</tr>
			@empty
			<tr><td colspan="13">{{trans("messages.no-records-found")}}</td></tr>
			@endforelse
		</tbody>
	</table>
  </div> -->
  
</div>

</div>
	</div>

</div>
<!-- Begin FusionCharts scripts -->
{{ HTML::script('fusioncharts/js/fusioncharts.js') }}
{{ HTML::script('fusioncharts/js/themes/fusioncharts.theme.ocean.js') }}
<!-- End fusioncharts scripts -->
<script type="text/javascript">
	$(document).ready(function(){
		reports();
	});

	FusionCharts.ready(function(){
	  var tatChart = new FusionCharts({id: "tat",type: "msline",
	      width: "100%",
	      height: "100%",
	      dataFormat: "json",
	      dataSource: <?php echo TatReportController::turnaroundtimeChart(date('Y-m-d'), date('Y-m-d')); ?>});
	  tatChart.render("chartContainer");
	});

	/*Begin function to change data for chart*/
   function changeData(data)
    {
    	$('#chartContainer').empty();
    	FusionCharts.ready(function(){
		  var updatedChart = new FusionCharts({type: "msline",
	      width: "100%",
	      height: "100%",
	      dataFormat: "json",
	      dataSource: data});
		  updatedChart.render("chart");
		});
    }
	/*End function to change chart data*/
</script>
@stop