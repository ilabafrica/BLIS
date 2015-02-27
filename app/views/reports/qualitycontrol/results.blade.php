@extends("layout")
@section("content")
<div>
	<ol class="breadcrumb">
	  <li><a href="{{{URL::route('user.home')}}}">{{ trans('messages.home') }}</a></li>
	  <li class="active">{{ trans('messages.control-results-log') }}</li>
	</ol>
</div>
<div class='container-fluid'>
    {{ Form::open(array('route' => array('reports.qualityControl'), 'id' => 'qc', 'class' => 'form-inline')) }}
    <div class='row'>
    	<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('start_date', trans('messages.from')) }}
				</div>
				<div class="col-sm-2">
				    {{ Form::text('start_date', isset($input['start_date'])?$input['start_date']:date('Y-m-d'), 
			                array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-sm-4">
	    	<div class="row">
				<div class="col-sm-2">
				    {{ Form::label('end_date', trans('messages.to')) }}
				</div>
				<div class="col-sm-2">
				    {{ Form::text('end_date', isset($input['end_date'])?$input['end_date']:date('Y-m-d'), 
			                array('class' => 'form-control standard-datepicker')) }}
		        </div>
			</div>
		</div>
		<div class="col-md-4">
	        <div class="col-md-3">
	        	{{ Form::label('control', Lang::choice('messages.control',1)) }}
	        </div>
	        <div class="col-md-9">
	            {{ Form::select('control',  array(null => '')+ $controlsDropDown,
	            	isset($input['control'])?$input['control']:0, array('class' => 'form-control')) }}
	        </div>
        </div>
        <div class="col-md-2">
        	{{Form::submit(trans('messages.view'), 
	        	array('class' => 'btn btn-info', 'id'=>'filter', 'name'=>'filter'))}}
        </div>
	</div>

	{{ Form::close() }}
</div>
<br />
<div class="panel panel-primary">
	<div class="panel-heading ">
		<span class="glyphicon glyphicon-user"></span> {{ trans('messages.daily-log') }} - {{ trans('messages.test-records') }}
	</div>

	<div class="panel-body">
	<!-- if there are search errors, they will show here -->
		<div id="test_records_div">
			@include("reportHeader")

			<table class="table table-bordered">
				<tbody>
					<tr>
						@foreach($control->controlMeasures as $controlMeasure)
							<th> {{ $controlMeasure->name }} </th>
						@endforeach
					</tr>
						@foreach($control->controlResults as $key => $controlresults)

							<td>{{ $key}}</td>
							<td>{{ $controlresults->results}}</td>
						@endforeach
				</tbody>

			
		</div>
	</div>
</div>

@stop