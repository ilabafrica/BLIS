@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active"><a href="{{ URL::route('reports.patient.index') }}">{{ Lang::choice('messages.report', 2) }}</a></li>
	  <li class="active">{{ trans('messages.prevalence-rates') }}</li>
	</ol>
</div>
{{ Form::open(array('route' => array('reports.aggregate.rejection'), 'id' => 'rejection_counts', 'method' => 'post')) }}
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
	        	{{ Form::label('specimen_type', Lang::choice('messages.specimen-type',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('specimen_type', array(0 => '-- All Specimen --')+SpecimenType::lists('name','id'),
	            	isset($input['spec_type'])?$input['spec_type']:0, array('class' => 'form-control')) }}
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
					Rejected Specimen per Reason Overtime
				</div>
				<div class="col-md-4" style="display:none;">
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
					    	<th>{{Lang::choice('messages.test-type',1)}}</th>
					    	<th>{{trans('messages.total-specimen')}}</th>
					    	<th>{{trans('messages.positive')}}</th>
					    	<th>{{trans('messages.negative')}}</th>
					    	<th>{{trans('messages.prevalence-rates-label')}}</th>
					    </tr>
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
		$('#highChart').highcharts(<?php echo $options; ?>);
	});
</script>
@stop