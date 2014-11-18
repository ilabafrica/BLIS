@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.prevalence-rates') }}</li>
	</ol>
</div>
@if (Session::has('message'))
	<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
@endif
{{ Form::open(array('url' => 'prevalence/filter', 'id' => 'prevalence_rates', 'method' => 'post')) }}
  	<table class="table table-responsive">
	    <thead>
		    <tr>
		        <td>{{ Form::label('from', trans("messages.from")) }}</td>
		        <td>
		            <input class="form-control standard-datepicker" name="start" type="text" 
		                    value="{{ isset($from) ? $from : date('Y-m-d') }}" id="start">
		        </td>
		        <td>{{ Form::label('to', trans("messages.to")) }}</td>
		        <td>
		            <input class="form-control standard-datepicker" name="end" type="text" 
		                    value="{{ isset($to) ? $to : date('Y-m-d') }}" id="end">
		        </td>
		        <td>{{ Form::button("<span class='glyphicon glyphicon-eye-open'></span> ".trans('messages.show-hide'), 
					        array('class' => 'btn btn-info', 'id' => 'reveal')) }}</td>
		        <td>{{ Form::button("<span class='glyphicon glyphicon-filter'></span> ".trans('messages.view'), 
					        array('class' => 'btn btn-primary', 'style' => 'width:125px', 'id' => 'filter', 'type' => 'submit')) }}</td>
		    </tr>
		</thead>
		<tbody>
		
		</tbody>
  	</table>
{{ Form::close() }}
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span>
		{{ trans('messages.prevalence-rates') }}
	</div>
	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		<div class="alert alert-danger" id="error" style="display:none;"></div>
		<div id="chartContainer" style="height:500px;"></div>
		<div id="chart" style="height:500px;display:none;"></div>
		<div class="table-responsive">
			<div id="summary" style="display:none;">
			  	<br>
				<div class="table-responsive">
				  <table class="table table-bordered" id="rates">
				   <tr>
				    	<th>{{trans('messages.test-type')}}</th>
				    	<th>{{trans('messages.total-specimen')}}</th>
				    	<th>{{trans('messages.positive')}}</th>
				    	<th>{{trans('messages.negative')}}</th>
				    	<th>{{trans('messages.prevalence-rates-label')}}</th>
				    </tr>
					<tbody  class="data">
					    @forelse($data as $datum)
					    <tr>
					    	<td>{{$datum->test}}</td>
			  				<td>{{$datum->total}}</td>
			  				<td>{{$datum->positive}}</td>
			  				<td>{{$datum->negative}}</td>
			  				<td>{{$datum->rate}}</td>
					    </tr>
					    @empty
					    <tr>
					    	<td colspan="5">{{trans('messages.no-records-found')}}</td>
					    </tr>
					    @endforelse
				    </tbody>
				  </table>
				</div>
			  </div>
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
		reportScripts();
	});

	FusionCharts.ready(function(){
	  var prevalenceChart = new FusionCharts({type: "msline",
	      width: "100%",
	      height: "100%",
	      dataFormat: "json",
	      dataSource: <?php echo ReportController::getPrevalenceRatesChart(); ?>});
	  prevalenceChart.render("chartContainer");
	});

	$('#toggle').click(function(){
   		$('#chartContainer').toggle('hide');
   		$('#chart').toggle('hide');
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