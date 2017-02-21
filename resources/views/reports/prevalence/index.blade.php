@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ trans_choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.prevalence-rates') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.aggregate.prevalence'), 'id' => 'prevalence_rates', 'method' => 'post')) }}
<div class="container-fluid">
  	<div class="row report-filter">
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('start', trans("messages.from")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('start', isset($input['start'])?$input['start']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-3">
	        <div class="col-md-2">
	        	{{ Form::label('to', trans("messages.to")) }}
	        </div>
	        <div class="col-md-10">
	            {{ Form::text('end', isset($input['end'])?$input['end']:date('Y-m-d'), 
	                array('class' => 'form-control standard-datepicker')) }}
	        </div>
        </div>
        <div class="col-md-4">
	        <div class="col-md-3">
	        	{{ Form::label('test_type', trans_choice('messages.test-type',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('test_type', $testType,
	            	isset($input['test_type'])?$input['test_type']:0, array('class' => 'form-control')) }}
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
		<div class="container-fluid">
			<div class="row less-gutter">
				<div class="col-md-8">
					<span class="glyphicon glyphicon-user"></span>
					{{ trans('messages.prevalence-rates') }}
				</div>
				<div class="col-md-4">
					<a class="btn btn-info pull-right" id="reveal" href="#" onclick="return false;"
                            alt="{{trans('messages.show-hide')}}" title="{{trans('messages.show-hide')}}">
                            <span class="glyphicon glyphicon-eye-open"></span> {{trans('messages.show-hide')}}</a>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
	<!-- if there are filter errors, they will show here -->
	@if (Session::has('message'))
		<div class="alert alert-info">{{ trans(Session::get('message')) }}</div>
	@endif
	<div class="table-responsive">
		<div id="summary" class="hidden">
		  	<div class="table-responsive">
			  <table class="table table-bordered" id="rates">
				  <tbody>
					   <tr>
					    	<th>{{trans_choice('messages.test-type',1)}}</th>
					    	<th>{{trans('messages.total-specimen')}}</th>
					    	<th>{{trans('messages.positive')}}</th>
					    	<th>{{trans('messages.negative')}}</th>
					    	<th>{{trans('messages.prevalence-rates-label')}}</th>
					    </tr>
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
			<div id="highChart"></div>
		  </div>
		</div>
	</div>
	</div>
</div>
<!-- Begin HighCharts scripts -->
{{ HTML::script('highcharts/highcharts.js') }}
{{ HTML::script('highcharts/exporting.js') }}
<!-- End HighCharts scripts -->
<script type="text/javascript">
	$(document).ready(function(){
		//	Load prevalence chart
		$('#highChart').highcharts(<?php echo $chart; ?>);
	});
</script>
@stop